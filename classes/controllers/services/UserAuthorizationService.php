<?php

namespace RedRock\Subscriptions;

class UserAuthorizationService extends Service {
    public $authCookieExtender  = new AuthCookieExtender;
    public $logoutHandler       = new LogoutHandler;
    
    public function emplaceCallbacks() {
        add_filter('auth_cookie_expiration',    array($authCookieExtender, "extendAuthCookieExpiration"));
        add_action('wp_logout',                 array($logoutHandler, "handleLogout"), 5000);
    }
}
