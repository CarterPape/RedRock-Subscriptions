<?php

namespace RedRock\Subscriptions;

class SettingsActionResponderSuite {
    private static $classDirectoryPathRelativeToPluginDirectory
        = "classes/controllers/settings-action-responders/";
    
    private $responderList  = array();
    private $classLoader;
    
    public function __construct() {
        $classLoader = new ClassLoader(
            $classDirectoryPathRelativeToPluginDirectory
        );
        $allResponderClasses = $classLoader->loadClasses();
        
        foreach ($allResponderClasses as $eachClass) {
            maybeAddToResponderList($eachClass);
        }
    }
    
    private function maybeAddToResponderList($class) {
        if (is_subclass_of($class, SettingsActionResponder::class)) {
            $responderList[$class] = new $class;
        }
    }
    
    public function getAllResponders() {
        return $responderList;
    }
}
