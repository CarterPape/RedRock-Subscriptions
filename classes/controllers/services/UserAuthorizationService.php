<?php

namespace RedRock\Subscriptions;

class UserAuthorizationService extends Service {
    public static $onlyActiveWhenConnectedToSubscriptionManagementService = true;
    private static $latePriority = 5000;
    
    public $authCookieExtender;
    public $logoutHandler;
    
    public function __construct() {
        $authCookieExtender     = new AuthCookieExtender;
        $loggerOutter           = new LoggerOutter;
    }
    
    public function emplaceCallbacks() {
        if (!Plugin::subscriptionManagementServiceConnection) {
            return;
        }
        
        add_filter(
            "auth_cookie_expiration",
            array(
                $authCookieExtender,
                "extendAuthCookieExpiration"
            )
        );
        
        $this->emplaceSubServLogoutCallback();
    }
    
    public function emplaceSubServLogoutCallback() {
        add_action(
            "wp_logout",
            array(
                $loggerOutter,
                "exitEarlyToFinishLogout"
            ),
            $latePriority
        );
    }
    
    public function removeLogoutCallback() {
        remove_action(
            "wp_logout",
            array(
                $loggerOutter,
                "exitEarlyToFinishLogout"
            ),
            $latePriority
        );
    }
}
