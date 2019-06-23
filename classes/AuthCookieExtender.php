<?php

namespace RedRockSubscriptions;

class AuthCookieExtender implements DoesPluginSetup {
    public function doPluginSetup() {
        add_filter('auth_cookie_expiration', array($this, "extendAuthCookieExpiration"));
    }
    
    public function extendAuthCookieExpiration {
        if (get_option('memberful_extend_auth_cookie_expiration')) {
            return WEEK_IN_SECONDS * 8;
        }
        else {
            return $expireIn;
        }
    }
}