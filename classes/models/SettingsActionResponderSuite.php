<?php

namespace RedRock\Subscriptions;

class SettingsActionResponderSuite {
    private static $classDirectoryPathRelativeToPluginDirectory = "classes/controllers/settings-action-responders/"
    
    private $responderList  = array();
    private $classLoader    = new ClassLoader($classDirectoryPathRelativeToPluginDirectory);
    
    public function __construct() {
        $allResponderClasses = $classLoader->loadClasses();
        
        foreach ($allResponderClasses as $eachClass) {
            maybeAddToSublcassList($eachClass);
        }
        
        hookDependentServices();
    }
    
    private function maybeAddToSublcassList($class) {
        if (is_subclass_of($class, SettingsActionResponder::class)) {
            $responderList[$class] = new $class;
        }
    }
    
    public function getAllResponders() {
        return $services;
    }
}
