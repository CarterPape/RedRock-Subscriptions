<?php

namespace RedRock\Subscriptions;

class AuthCookieExtender {
    public function extendAuthCookieExpiration() {
        if (get_option("memberful_extend_auth_cookie_expiration")) {
            return WEEK_IN_SECONDS * 8;
        }
        else {
            return $expireIn;
        }
    }
}
