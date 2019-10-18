<?php

die("incomplete implementation");

namespace RedRock\Subscriptions;

abstract class SettingsSubpage extends View {
    private $settingsService = Plugin::getServiceByClass(SettingsService::class);
    
    public static function getSlug();
    public static function getNiceName();
    
    public function renderNonceField() {
        echo $settingsService->getNonceField();
    }
}
