<?php

namespace RedRock\Subscriptions;

abstract class SettingsActionResponder extends ActionResponder {
    protected $settingsActionTag;
    
    protected $settingsService          = Plugin::getServiceByClass(SettingsService::class);
    protected $pluginName               = Plugin::getDefinitions()->getPluginName();
    protected $redirectHTTPStatusCode   = 302;
    
    public function getActionTag() {
        return "admin_post_" . $settingsActionTag;
    }
    
    protected function verifyRequest() {
        user_can("change settings")
        wp_verify_nonce();
    }
    
    protected function redirectToPluginSettingsPage() {
        $settingsPageURL = $settingsService->getSettingsSubPageURL();
        
        wp_redirect(
            $settingsPageURL,
            $redirectHTTPStatusCode,
            $pluginName
        );
        exit();
    }
    
    public function respondToAction() {
        redirectToPluginSettingsPage();
    }
}
