<?php

namespace RedRock\Subscriptions;

exit("incomplete implementation");

class LogoutHandler {
    function memberful_wp_ensure_user_logged_out_of_memberful() {
        if (!memberful_wp_is_connected_to_site()) {
            return;
        }

        if (memberful_wp_endpoint_for_request() !== NULL) {
            return;
        }

        wp_safe_redirect(memberful_sign_out_url());
        exit();
    }
}
