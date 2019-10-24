<?php

namespace RedRock\Subscriptions;

class ContentAccessCircumstances extends Bean {
    public $userSubscriptionState   = null;
    const userHasActiveSubscription = 0x00;
    const userSubscriptionSuspended = 0x01;
    const userSubscriptionExpired   = 0x02;
    
    public $userFreeQuotaState      = null;
    const userStillUnderFreeQuota   = 0x10;
    const userHitFreeQuota          = 0x11;
    
    public $contentFreedom      = null;
    const contentIsProtected    = 0x20;
    const contentIsFree         = 0x21;
}
