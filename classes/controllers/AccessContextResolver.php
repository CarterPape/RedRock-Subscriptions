<?php

namespace RedRock\Subscriptions;

class AccessContextResolver {
    private $contentAccessContext       = null;
    
    private $quotaTrackingService       = null;
    private $cookieTestService          = null;
    
    private $filterPredicateList        = null;
    
    public function __construct(
        &$contentAccessContext,
        &$contentViewFactory,
        $filterPredicateList
    ) {
        $this->contentAccessContext = $contentAccessContext;
        $this->contentViewFactory   = $contentViewFactory;
        $this->filterPredicateList  = $filterPredicateList;
        
        $quotaTrackingService
            = Plugin::getServiceByClass(QuotaTrackingService::class);
            
        $cookieTestService
            = Plugin::getServiceByClass(CookieTestService::class);
    }
    
    public function resolveAccessContext() {
        doOnlyRequiredContextChecks();
    }
    
    private function doOnlyRequiredContextChecks() {
        enterLogicTree();
    }
    
    private function enterLogicTree() {
        handlePossibleCrawler();
    }
    
    private function handlePossibleCrawler() {
        switch ($contentAccessContext->getClientCrawlerStatus()) {
            case (ContentAccessContext::kUserIsCrawler):
                $contentViewFactory->setContentToBeUnabridged();
                $contentViewFactory->deactivatePreContentBlurb();
            break;
            
            case (ContentAccessContext::kUserNotRecognizedAsCrawler):
                handleHumanClient();
            break;
            
            default:
                $errorCulprit = "crawlers status of client";
                throw new InconsistentAccessContextException($errorCulprit);
            break;
        }
    }
    
    private function handleHumanClient() {
        switch ($contentAccessContext->getWPLoginStatus()) {
            case (ContentAccessContext::kUserNotLoggedInToWPAccount):
                handleUserAsQuotaSubject();
            break;
            
            case (ContentAccessContext::kUserIsLoggedInToWPAccount):
                handleUserLoggedIntoWP();
            break;
            
            default:
                $errorCulprit = "WordPress login status of user";
                throw new InconsistentAccessContextException($errorCulprit);
            break;
        }
    }
    
    private function handleUserLoggedIntoWP() {
        switch ($contentAccessContext->checkForExistingSubServLinkage()) {
            case (ContentAccessContext::kRequesterAlreadyLinkedToSubServ):
                handleUserWithSubServLinkage();
            break;
            
            case (ContentAccessContext::kNoExistingSubServLinkForRequester):
                handleUserWithoutExistingSubServLinkage();
            break;
            
            default:
                $errorCulprit
                    = "status of existing linkage between the subscription service and the WordPress user who is requesting the content";
                throw new InconsistentAccessContextException($errorCulprit);
            break;
        }
    }
    
    private function handleUserWithoutExistingSubServLinkage() {
        switch ($contentAccessContext->checkWPUserElevation()) {
            case (ContentAccessContext::kUserIsMoreThanASubscriber):
                $contentViewFactory->setContentToBeUnabridged();
                $contentViewFactory->deactivatePreContentBlurb();
            break;
            
            case (ContentAccessContext::kUserHasSubscriberRole):
                handleUnlinkedSubscriber();
            break;
            
            default:
                $errorCulprit = "elevation of WordPress user";
                throw new InconsistentAccessContextException($errorCulprit);
            break;
        }
    }
    
    private function handleUnlinkedSubscriber() {
        $linkingError = null;
        
        $subscriberAccountsManager->attemptToLinkWPAccountToSubServ(
            $contentAccessContext->currentUser,
            $linkingError
        );
        
        if ($linkingError === null) {
            handleUserWithSubServLinkage();
        }
        else {
            $contentViewFactory->setAccountMessage(
                new NoSubServAccountFoundMessage
            );
            wp_logout();
            handleUserAsQuotaSubject();
        }
    }
    
    private function handleUserWithSubServLinkage() {
        switch ($contentAccessContext->getSubscriptionStatus()) {
            case (ContentAccessContext::kUserHasActiveSubscription):
                $contentViewFactory->setContentToBeUnabridged();
                $contentViewFactory->deactivatePreContentBlurb();
            break;
            
            case ContentAccessContext::kUserSubscriptionExpired:
                $contentViewFactory->setAccountMessage(
                    new SubscriptionExpiredMessage
                );
                handleUserAsQuotaSubject();
            break;
            
            case ContentAccessContext::kUserSubscriptionSuspended:
                $contentViewFactory->setAccountMessage(
                    new AccountSuspendedMessage
                );
                handleUserAsQuotaSubject();
            break;
            
            case ContentAccessContext::kUserHasNoSubscription:
                $contentViewFactory->setAccountMessage(
                    new NoSubscriptionMessage
                );
                handleUserAsQuotaSubject();
            break;
            
            default:
                $errorCulprit
                    = "subscription and account status of the subscription service user requesting the content";
                throw new InconsistentAccessContextException($errorCulprit);
            break;
        }
    }
    
    private function handleUserAsQuotaSubject() {
        switch ($contentAccessContext->getExistingCookieStatus()) {
            case (ContentAccessContext::kUserHasAnyCookie):
                handleUserWhoAllowsCookies();
            break;
            
            case (ContentAccessContext::kUserHasNoCookies):
                handleUserWhoHasNoCookies();
            break;
            
            default:
                $errorCulprit = "preexistence of cookies";
                throw new InconsistentAccessContextException($errorCulprit);
            break;
        }
    }
    
    private function handleUserWhoAllowsCookies() {
        $quotaTrackingService->maybeInitQuotaTrackingForCurrentVisitor();
        checkFiltersThenQuota();
    }
    
    private function handleUserWhoHasNoCookies() {
        switch ($contentAccessContext->getCookieTestStatus()) {
            case (ContentAccessContext::kCookieTestReturnedNegative):
                $contentViewFactory
                    ->enableMessageAboutUserBeingUnidentifiable();
                checkFiltersThenQuota();
            break;
            
            case (ContentAccessContext::kNoCookieTestExecuted):
                $cookieTestService->exitEarlyToExecuteDiscreetCookieTest();
            break;
            
            default:
                $errorCulprit
                    = "whether a cookie test was just now attempted or, if it was, that it returned negative (since a check for the existence of any cookies already took place)";
                throw new InconsistentAccessContextException($errorCulprit);
            break;
        }
    }
    
    private function checkFiltersThenQuota() {
        $predicateResult = null;
        
        foreach ($filterPredicateList as $currentFilterPredicate) {
            $predicateResult
                = $currentFilterPredicate->evaluate($contentAccessContext);
            
            if ($predicateResult !== null) {
                $contentViewFactory->setFilterMessage(
                    $currentFilterPredicate->getMessage()
                );
                break;
            }
        }
        
        if ($predicateResult === null) {
            filterContentBasedOnQuota();
        }
        else {
            handleTriggeredFilterPredicate($predicateResult);
        }
    }
    
    private function filterContentBasedOnQuota() {
        if (
            $contentAccessContext->getExistingCookieStatus()
                === ContentAccessContext::kUserHasAnyCookie
            && $quotaTrackingService->requesterIsBelowQuota()
            
        ) {
            $quotaTrackingService->incrementRequestersReadCount();
            $contentViewFactory->setContentToBeUnabridged();
            $contentViewFactory->enableQuotaMessage();
        }
        else if (
            $contentAccessContext->cookieTestJustAttempted()
                === ContentAccessContext::kCookieTestReturnedNegative
        ) {
            $contentViewFactory->enableMessageAboutUserBeingUnidentifiable();
            $contentViewFactory->setContentToBeAbridged();
        }
        else {
            // This is the case where the user has cookies enabled, they already hit their quota for the month, and there was no filter predicate triggered, so the content is blocked for them and they are presented with the abridged content and paywall.
            handleUserWithCookiesWhoAlreadyHitQuota();
        }
    }
    
    private function setContentVisibilty($showFullContent) {
        if ($showFullContent) {
            $contentViewFactory->setContentToBeUnabridged();
        }
        else {
            $contentViewFactory->setContentToBeAbridged();
        }
    }
    
    private function handleUserWithCookiesWhoAlreadyHitQuota() {
        $contentViewFactory->setContentToBeAbridged();
        $contentViewFactory->enableQuotaMessage();
    }
}
