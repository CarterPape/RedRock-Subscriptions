<?php

namespace RedRock\Subscriptions;

/*
    A ContentProtectionService instance is a service. It is reponsible for protecting content on the website. The service protects content by withholding it from the user unless the service can prove the user may access it.
    
    Part of protecting content is replacing it with marketing material when it is withheld and, perhaps, notifying the user of the number of free articles left.
    
    It is key to, as much as possible, minimize interruption of active subscribers' access to content. This service should be optimized to serve them first.
*/

class ContentProtectionService extends Service {
    private $requestedContent           = null;
    private $contentToReturn            = null;
    private $contentAccessContext       = null;
    
    public function emplaceCallbacks() {
        add_filter(
            "the_content",
            array(
                $this,
                "maybeProtectContent"
            )
        );
    }
    
    public function maybeProtectContent($the_content) {
        if (is_single() && in_the_loop() && is_main_query()) {
            protectTheContent();
        }
        else {
            $contentToReturn = $the_content;
        }
        return $contentToReturn;
    }
    
    private function protectTheContent($theContent) {
        $requestedContent = $theContent;
        $contentAccessContext = new ContentAccessContext;
        $contentAccessContext->scout = new ContentAccessContextScout;
        $currentUser = (new UserScout).getCurrentUser();
        
        $contentAccessContext->scout.checkContentFreedom();
        
        if ($contentAccessContext.contentIsFree()) {
            provideFullContent();
        }
        else {
            handleProtectedContent();
        }
    }
    
    private function provideFullContent() {
        $contentToReturn = $requestedContent;
    }
    
    private function handleProtectedContent() {
        $contentAccessContext->scout->checkUserRobotStatus();
        
        if ($contentAccessContext->robotUserIsTrusted()) {
            provideFullContent();
        }
        else if ($contentAccessContext->userNotRecognizedAsRobot()) {
            handleUserAsHuman();
        }
        else {
            give403WithSnippet(ForbiddenView::badRobot);
        }
    }
    
    private function handleUserAsHuman() {
        $contentAccessContext->scout->checkLoginStatus();
        
        if ($contentAccessContext->userIsLoggedInToWPAccount()) {
            handleLoggedInUser();
        }
        else {
            handleUserAsQuotaSubject();
        }
    }
    
    private function handleLoggedInUser() {
        $contentAccessContext->scout->checkForMemberfulLinkage();
        
        if ($contentAccessContext->wordpressUserAlreadyLinkedToMemberful()) {
            handleUserWithMemberfulLinkage();
        }
        else {
            handleUserWithoutMemberfulLinkage();
        }
    }
    
    private function handleUserWithMemberfulLinkage() {
        $contentAccessContext->scout->checkForSubscriptionStatus();
        
        if ($contentAccessContext->userHasActiveSubscription()) {
            provideFullContent();
        }
        else if ($contentAccessContext->userSubscriptionExpired()) {
            handleUserWithExpiredSubscription();
        }
        else if ($contentAccessContext->userSubscriptionSuspended()) {
            handleUserWithSuspendedSubscription();
        }
        else {
            handleUserWithoutSubscription();
        }
    }
    
    private function handleUserAsQuotaSubject() {
        $contentAccessContext->scout->checkForQuotaCookie();
        
        if ($contentAccessContext->userHasExistingQuotaCookie()) {
            handleUserWithQuotaCookie();
        }
        else {
            handleUserWithoutQuotaCookie();
        }
    }
    
    private function handleWPUserWithoutMemberfulLinkage() {
        $contentAccessContext->scout->checkUserElevation();
        
        if (userIsMoreThanASubscriber()) {
            provideFullContent();
        }
        else {
            tryToLinkWPUserToMemberful();
        }
    }
    
    private function handleUserWithExpiredSubscription() {
        
    }
    
    private function handleUserWithSuspendedSubscription() {
        
    }
    
    private function handleUserWithoutSubscription() {
        
    }
    
    private function handleUserWithSubscriberRole() {
        
    }
    
    private function handleUserWithQuotaCookie() {
        $contentAccessContext->scout->checkUserReadCount();
        
        if ($contentAccessContext->userStillUnderFreeQuota()) {
            giveFullContentWithQuotaSnippet(QuotaView::stillUnderQuota);
        }
        else {
            give403WithSnippet(ForbiddenView::hitFreeQuota);
        }
    }
    
    private function handleUserWithoutQuotaCookie() {
        $contentAccessContext->scout->askUserAboutCookieAllergy();
        
        if ($contentAccessContext->userAcceptCookies()) {
            giveFullContentWithQuotaSnippet(QuotaView::newQuota);
        }
        else {
            give403WithSnippet(ForbiddenView::privateSession);
        }
    }
    
    private function giveFullContentWithQuotaSnippet($snippetKey) {
        $quotaView = new QuotaView($requestedContent, $snippetKey);
        $contentToReturn = $quotaView.returnIt();
    }
    
    private function give403WithSnippet($snippetKey) {
        $forbiddenView = new ForbiddenView($requestedContent, $snippetKey);
        $contentToReturn = $forbiddenView.returnIt();
    }
}
