<?php

namespace RedRock\Subscriptions;

class SettingsService extends DependentService {
    private $pluginName;
    private $settingsPageDisplayName;
    private $settingsPageSlug;
    private $settingsPageURL;
    
    private $synchronizationService;
    private $settingsViewController;
    
    private $settingsDBConnection;
    private $settingsActionResponderSuite;
    
    public function __construct() {
        $pluginName                 = Plugin::getDefinitions()->getPluginName();
        $settingsPageDisplayName    = $pluginName;
        $settingsPageSlug           = "RedRock-Subscriptions-settings";
        $settingsPageURL            = admin_url(
            "options-general.php?page={$settingsPageSlug}"
        );
        
        $settingsViewController = new SettingsViewController;
        
        $settingsDBConnection           = new SettingsDBConnection;
        $settingsActionResponderSuite   = new SettingsActionResponderSuite;
    }
    
    public function emplaceCallbacks() {
        register_activation_hook(
            Plugin::getDefinitions()->getPluginFile(),
            array($settingsDBConnection, "respondToPluginActivation")
        );
        
        add_options_page(
            $settingsPageDisplayName,
            $settingsPageDisplayName,
            'manage_options',
            $settingsPageSlug,
            array($settingsViewController, "renderView")
        );
        
        $settingsActionResponderList =
            $settingsActionResponderSuite->getResponderList();
        
        foreach ($settingsActionResponderList as $eachSettingsActionResponder) {
            add_action(
                $eachSettingsActionResponder->getActionTag(),
                array(
                    $eachSettingsActionResponder,
                    "respondToAction"
                )
            );
        }
    }
    
    public function getSettingsPageURL() {
        return $settingsPageURL;
    }
    
    public function takeDependencies(array $allServicesByClass) {
        $synchronizationService
            = $allServicesByClass[SynchronizationService::class];
    }
    
    public function resetSettings() {
        $settingsDBConnection->resetSettings();
    }

    /**
     * Displays the page for registering the WordPress plugin with memberful.com
     */
    function memberful_wp_register() {
        if (isset($_POST['activation_code'])) {
            if (! empty($_POST['activation_code'])) {
                $activation = memberful_wp_activate($_POST['activation_code']);

                if ($activation === TRUE) {
                    update_option('memberful_embed_enabled', TRUE);
                    memberful_wp_sync_downloads();
                    memberful_wp_sync_subscription_plans();
                }
                else {
                    Reporter::report($activation, 'error');
                }
            }

            return wp_redirect(admin_url('options-general.php?page=memberful_options'));
        }

        memberful_wp_render('setup');
    }
}
