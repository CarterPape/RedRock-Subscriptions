<?php

namespace RedRock\Subscriptions;

class PluginActivationStatusResponseService extends DependentService {
    private $settingsService;
    
    public function emplaceCallbacks() {
        register_activation_hook(
            Plugin::getDefinitions()->getPluginFile(),
            array(
                $this,
                "respondToPluginActivation"
            )
        );
        
        add_action(
            'admin_init', 
            array(
                $this,
                "maybeRedirectToSettingsPage"
            )
        );
    }
    
    public function takeDependencies($allServicesByClass) {
        $settingsService = $allServicesByClass[SettingsService::class];
    }
    
    public function respondToPluginActivation() {
        add_option("RedRock_Subscriptions_just_activated" , TRUE);
    }
    
    public function maybeRedirectToSettingsPage() {
        $assumedAnswer = FALSE;
        $pluginWasJustActivated = get_option(
            'RedRock_Subscriptions_just_activated',
            $assumedAnswer
        );
        
        if ($pluginWasJustActivated) {
            update_option(
                'RedRock_Subscriptions_just_activated',
                FALSE
            );
            
            $activatingInMultisiteContext = isset($_GET['activate-multi']);
            
            if (!$activatingInMultisiteContext) {
                $settingsService->redirectToPluginSettingsPage();
            }
        }
    }
}
