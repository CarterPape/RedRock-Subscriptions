<?php

namespace RedRock\Subscriptions;

class SettingsDBConnection extends DBConnection {
    private function settingsAndBlankValues() {
        return array(
            "RRS_memberful_client_id"           => NULL,
            "RRS_memberful_client_secret"       => NULL,
            "RRS_memberful_site"                => NULL,
            "RRS_memberful_api_key"             => NULL,
            "RRS_memberful_webhook_secret"      => NULL,
            "RRS_memberful_downloads"           => array(),
            "RRS_memberful_subscriptions"       => array(),
            "RRS_memberful_embed_enabled"       => FALSE,
            "RRS_error_log"                     => array(),
            "RRS_role_for_active_customers"     => "subscriber",
            "RRS_role_for_inactive_customers"   => "subscriber",
            "RRS_default_marketing_content"     => NULL,
            "RRS_universal_free_reads_quota"    => 3
        );
    }
    
    private function connectionOptions() {
        return array(
            "RRS_memberful_client_id",
            "RRS_memberful_client_secret",
            "RRS_memberful_api_key",
            "RRS_memberful_webhook_secret"
        );
    }
    
    public function resetConnectionSettings() {
        $defaults = settingsAndBlankValues();

        foreach (connectionOptions() as $option) {
            update_option($option, $defaults[$option]);
        }
    }
    
    public function respondToPluginActivation() {
        foreach (settingsAndBlankValues() as $option => $default) {
            add_option($option, $default);
        }
        
        add_option("RedRock_Subscriptions_just_activated", TRUE);
    }
}
