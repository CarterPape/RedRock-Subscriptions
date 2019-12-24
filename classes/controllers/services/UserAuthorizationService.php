<?php

namespace RedRock\Subscriptions;

class UserAuthorizationService extends Service {
    public $authCookieExtender;
    public $logoutHandler;
    
    public function __construct() {
        $authCookieExtender  = new AuthCookieExtender;
        $logoutHandler       = new LogoutHandler;
    }
    
    public function emplaceCallbacks() {
        add_filter(
            "auth_cookie_expiration",
            array(
                $authCookieExtender,
                "extendAuthCookieExpiration"
            )
        );
        add_action(
            "wp_logout",
            array(
                $logoutHandler,
                "handleLogout"
            ),
            5000
        );
    }
}
