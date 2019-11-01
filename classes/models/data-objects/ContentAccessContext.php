<?php

namespace RedRock\Subscriptions;

class ContentAccessContext extends Bean {
    public $scout;
    
    public function __construct() {
        $scout = new ContentAccessContextScout;
        $scout->setOwner($this);
    }
    
    public $currentUser;
    
    public $contentFreedom      = null;
    const contentIsProtected    = 0x00;
    const contentIsFree         = 0x01;
    
    public function contentIsProtected() {
        return $contentFreedom == self::contentIsProtected;
    }
    
    public function contentIsFree() {
        return $contentFreedom == self::contentIsFree;
    }
    
    public $userRobotStatus         = null;
    const userNotRecognizedAsRobot  = 0x10;
    const robotUserIsTrusted        = 0x11;
    const robotUserIsNotTrusted     = 0x12;
    
    public function userNotRecognizedAsRobot() {
        return $userRobotStatus == self::userNotRecognizedAsRobot;
    }
    
    public function robotUserIsTrusted() {
        return $userRobotStatus == self::robotUserIsTrusted;
    }
    
    public function robotUserIsNotTrusted() {
        return $userRobotStatus == self::robotUserIsNotTrusted;
    }
    
    public $wordpressLoginStatus        = null;
    const userNotLoggedInToWPAccount    = 0x20;
    const userIsLoggedInToWPAccount     = 0x21;
    
    public function userNotLoggedInToWPAccount() {
        return $wordpressLoginStatus == self::userNotLoggedInToWPAccount;
    }
    
    public function userIsLoggedInToWPAccount() {
        return $wordpressLoginStatus == self::userIsLoggedInToWPAccount;
    }
    
    public $memberfulLinkageStatus              = null;
    const wordpressUserAlreadyLinkedToMemberful = 0x30;
    const noExistingMemberfulLinkForWPUser      = 0x31;
    
    public function wordpressUserAlreadyLinkedToMemberful() {
        return $memberfulLinkageStatus == self::wordpressUserAlreadyLinkedToMemberful;
    }
    
    public function noExistingMemberfulLinkForWPUser() {
        return $memberfulLinkageStatus == self::noExistingMemberfulLinkForWPUser;
    }
    
    public $wordpressUserElevation  = null;
    const userIsMoreThanASubscriber = 0x40;
    const userHasSubscriberRole     = 0x41;
    
    public function userIsMoreThanASubscriber() {
        return $wordpressUserElevation == self::userIsMoreThanASubscriber;
    }
    
    public function userHasSubscriberRole() {
        return $wordpressUserElevation == self::userHasSubscriberRole;
    }
    
    public $memberfulMapAttemptStatus   = null;
    const mapAttemptSuccessful          = 0x50;
    const mapAttemptUnsuccessful        = 0x51;
    
    public function mapAttemptSuccessful() {
        return $memberfulMapAttemptStatus == self::mapAttemptSuccessful;
    }
    
    public function mapAttemptUnsuccessful() {
        return $memberfulMapAttemptStatus == self::mapAttemptUnsuccessful;
    }
    
    public $memberfulSubscriptionStatus = null;
    const userHasActiveSubscription     = 0x60;
    const userSubscriptionExpired       = 0x61;
    const userSubscriptionSuspended     = 0x62;
    const userHasNoSubscription         = 0x63;
    
    public function userHasActiveSubscription() {
        return $memberfulSubscriptionStatus == self::userHasActiveSubscription;
    }
    
    public function userSubscriptionExpired() {
        return $memberfulSubscriptionStatus == self::userSubscriptionExpired;
    }
    
    public function userSubscriptionSuspended() {
        return $memberfulSubscriptionStatus == self::userSubscriptionSuspended;
    }
    
    public function userHasNoSubscription() {
        return $memberfulSubscriptionStatus == self::userHasNoSubscription;
    }
    
    public $existingQuotaCookieStatus   = null;
    const userHasExistingQuotaCookie    = 0x70;
    const noExistingQuotaCookieWithUser = 0x71;
    
    public function userHasExistingQuotaCookie() {
        return $existingQuotaCookieStatus == self::userHasExistingQuotaCookie;
    }
    
    public function noExistingQuotaCookieWithUser() {
        return $existingQuotaCookieStatus == self::noExistingQuotaCookieWithUser;
    }
    
    public $userReadCountState      = null;
    const userStillUnderFreeQuota   = 0x80;
    const userHitFreeQuotaThisMonth = 0x81;
    
    public function userStillUnderFreeQuota() {
        return $userReadCountState == self::userStillUnderFreeQuota;
    }
    
    public function userHitFreeQuotaThisMonth() {
        return $userReadCountState == self::userHitFreeQuotaThisMonth;
    }
    
    public $userCookieAllergyStatus = null;
    const userAcceptsCookies        = 0x90;
    const userDoesNotAcceptCookies  = 0x91;
    
    public function userAcceptsCookies() {
        return $userCookieAllergyStatus == self::userAcceptsCookies;
    }
    
    public function userDoesNotAcceptCookies() {
        return $userCookieAllergyStatus == self::userDoesNotAcceptCookies;
    }
}
