<?php

namespace RedRock\Subscriptions;

class ExistingMemberfulConnectionSubpage extends SettingsSubview {
    public static function getPublicName() {
        return "existing_connection";
    }
    
    public static function getNiceName() {
        return "Existing connection to Memberful";
    }
    
    public function renderIt() {
        $downloads = get_option('memberful_downloads', array());
        $subscriptions = get_option('memberful_subscriptions', array());
        $extend_auth_cookie_expiration = get_option('memberful_extend_auth_cookie_expiration');

        memberful_wp_render(
            'options',
            array(
                'downloads' => $downloads,
                'subscriptions' => $subscriptions,
                'extend_auth_cookie_expiration' => $extend_auth_cookie_expiration
            )
        );
    }
}
