<?php

namespace RedRock\Subscriptions;

class SettingsViewController {
    private $view;
    
    private $pluginName             = Plugin::getDefinitions()->getPluginName();
    private $redirectHTTPStatusCode = 302;
    
    private $settingsService        = Plugin::getServiceByClass(SettingsService::class);
    private $synchronizationService = Plugin::getServiceByClass(SynchronizationService::class);
    private $settingsSubpagesLoader = new SettingsSubpagesLoader;
    
    private $subpagesBySlug;
    private $defaultSubpage;
    private $currentSubpage;
    
    public function __construct() {
        $subpagesBySlug = $settingsSubpagesLoader->getSlugToSubpageDict();
        $defaultSubpage
            = $subpagesBySlug[ExistingMemberfulConnectionSubpage::getSlug()];
        setUpView();
    }
    
    public function redirectToPluginSettingsPage() {
        $settingsPageURL    = $settingsService->getSettingsSubPageURL();
        
        wp_redirect(
            $settingsPageURL,
            $redirectHTTPStatusCode,
            $pluginName
        );
        exit();
    }
    
    //?
    public function determineVisibleSubpageAndTabs() {
        $tabViewToRender            = NULL;
        $flashMessageViewToRender   = NULL;
        
        if (!function_exists('curl_version')) {
            $currentSubpage = 
        }
        else if (!$settingsService->pluginIsConnected()) {
            $currentSubpage = $subpagesBySlug[MemberfulConnectionActivationSubpage::getSlug()];
        }
        else if (isset($subpagesBySlug[$_REQUEST["subpage"]]) {
            $currentSubpage     = $subpagesBySlug[$_REQUEST["subpage"]];
            $tabViewToRender    = constructDefaultTabView();
        }
        else {
            $currentSubpage     = $defaultSubpage;
            $tabViewToRender    = constructDefaultTabView();
        }
        
        $view = new SettingsView($currentSubpage, $tabViewToRender, $flashMessageViewToRender);
    }
    
    // move this
    public function getNonceField() {
        return wp_nonce_field("save_RRS_settings", "RedRock_Subscriptions_nonce");
    }
    
    //?
    public function renderView() {
        if () {
            $settingsService->loadCURLComplaintPage();
        }
        else if (!$settingsService->siteIsConnectedToMemberful()) {
            $settingsService->loadRegistrationPage();
        }
        
        $currentSubpage->renderInPlace();
    }
    
    private function handleNormalSettingsPostback() {
        if (isset($_REQUEST['manual_sync'])) {
            $synchronizationService->syncSubscriptionPlans();
        }
        else if (isset($_REQUEST['reset_plugin'])) {
            $settingsService->resetSettings();
        }
    }
    
    private function handleConnectionPostback() {
        if (isset($_REQUEST['activation_code'])) {
            $success = FALSE;
            $settingsService->attemptConnectionUsingCode($_REQUEST['activation_code'], $success);
            
            if (!empty($_REQUEST['activation_code'])) {
                $activation = memberful_wp_activate();

                if ($activation === TRUE) {
                    update_option('memberful_embed_enabled', TRUE);
                    memberful_wp_sync_downloads();
                    memberful_wp_sync_subscription_plans();
                }
                else {
                    Reporter::report($activation, 'error');
                }
            }

            reloadCurrentSettingsPage();
        }
    }
    
    public function getSubpageToRender() {
        return $currentSubpage;
    }
}
