<?php

namespace RedRock\Subscriptions;

class ContentAccessContext {
    private $requester;
    private $requestedContent;
    
    public function __construct(string $requestedContent) {
        $this->requestedContent = $requestedContent;
    }
    
    public function getRequester() {
        return $requester;
    }
    
    public function getRequestedContent() {
        return $requestedContent;
    }
    
    private $clientCrawlerStatus                = null;
    public const kUserNotRecognizedAsCrawler    = 0x10;
    public const kUserIsCrawler                 = 0x11;
    
    public function getClientCrawlerStatus() {
        if ($clientCrawlerStatus === null) {
            getClientCrawlerStatusCore();
        }
        
        return $clientCrawlerStatus;
    }
    
    private function getClientCrawlerStatusCore() {
        if (
            isset($_SERVER['HTTP_USER_AGENT'])
            && preg_match(
                '/bot|crawl|slurp|spider|mediapartners/i',
                $_SERVER['HTTP_USER_AGENT']
            )
        ) {
            $clientCrawlerStatus = self::kUserIsCrawler;
        }
        else {
            $clientCrawlerStatus = self::kUserNotRecognizedAsCrawler;
        }
    }
    
    private $wordpressLoginStatus               = null;
    public const kUserNotLoggedInToWPAccount    = 0x20;
    public const kUserIsLoggedInToWPAccount     = 0x21;
    
    public function getWPLoginStatus() {
        if ($wordpressLoginStatus === null) {
            getWPLoginStatusCore();
        }
        
        return $wordpressLoginStatus;
    }
    
    private function getWPLoginStatusCore() {
        $wordpressLoginStatus = 
            is_user_logged_in()
                ? self::kUserIsLoggedInToWPAccount
                : self::kUserNotLoggedInToWPAccount;
    }
    
    private $subServLinkageStatus                   = null;
    public const kRequesterAlreadyLinkedToSubServ   = 0x30;
    public const kNoExistingSubServLinkForRequester = 0x31;
    
    public function checkForExistingSubServLinkage() {
        if ($subServLinkageStatus === null) {
            checkForExistingSubServLinkageCore();
        }
        
        return $subServLinkageStatus;
    }
    
    private function checkForExistingSubServLinkageCore() {
        
    }
    
    private $wordpressUserElevation         = null;
    public const kUserIsMoreThanASubscriber = 0x40;
    public const kUserHasSubscriberRole     = 0x41;
    
    public function userIsMoreThanASubscriber() {
        if ($wordpressUserElevation === null) {
            userIsMoreThanASubscriberCore();
        }
        
        return $wordpressUserElevation;
    }
    
    private function userIsMoreThanASubscriberCore() {
        
    }
    
    private $subServSubscriptionStatus    = null;
    public const kUserHasActiveSubscription = 0x60;
    public const kUserSubscriptionExpired   = 0x61;
    public const kUserSubscriptionSuspended = 0x62;
    public const kUserHasNoSubscription     = 0x63;
    
    public function getSubscriptionStatus() {
        if ($subServSubscriptionStatus === null) {
            getSubscriptionStatusCore();
        }
        
        return $subServSubscriptionStatus;
    }
    
    private function getSubscriptionStatusCore() {
        
    }
    
    private $existingCookieStatus   = null;
    public const kUserHasAnyCookie  = 0x70;
    public const kUserHasNoCookies  = 0x71;
    
    public function getExistingCookieStatus() {
        if ($existingCookieStatus === null) {
            getExistingCookieStatusCore();
        }
        
        return $existingCookieStatus;
        
    }
    
    public function getExistingCookieStatusCore() {
        
    }
    
    private $cookieTestStatus                   = null;
    private const kCookieTestReturnedNegative   = 0xA0;
    private const kNoCookieTestExecuted         = 0xA1;
    
    public function getCookieTestStatus() {
        if ($cookieTestStatus === null) {
            getCookieTestStatusCore();
        }
        
        return $cookieTestStatus;
    }
    
    private function getCookieTestStatusCore() {
        
    }
}
