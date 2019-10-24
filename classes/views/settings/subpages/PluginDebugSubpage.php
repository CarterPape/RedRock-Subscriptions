<?php

namespace RedRock\Subscriptions;

class PluginDebugSubpage extends SettingsSubpage {
    public static function getSlug() {
        return "plugin_debug";
    }
    
    public static function getNiceName() {
        return "Debug plugin";
    }
    
    %%%;
}
