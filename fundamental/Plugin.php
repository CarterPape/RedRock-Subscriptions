<?php

namespace RedRock\Subscriptions;

require_once "PluginDefinitions.php";
require_once "AutoLoader.php";

class Plugin {
    private static $defaultInstance;
    
    private $pluginDefinitions;
    private $autoLoader;
    private $rootServiceSpawner;
    
    public static function spawn($pluginFile) {
        if ($defaultInstance === null) {
            $defaultInstance = new self($pluginFile);
        }
        return $defaultInstance;
    }
    
    public static function defaultInstance() {
        return $defaultInstance;
    }
    
    public static function getDefinitions() {
        return $defaultInstance->pluginDefinitions;
    }
    
    public static function getServiceByClass($class) {
        return $defaultInstance->getServiceByClass($class);
    }
    
    
    protected function __construct($pluginFile) {
        $pluginDefinitions = new PluginDefinitions($pluginFile);
        $autoLoader = new AutoLoader;
        $audoLoader->hookAutoLoader();
        
        $serviceSuite = new ServiceSuite;
        $rootServiceSpawner = new RootServiceSpawner($serviceSuite);
    }
    
    private function __clone() {}
    private function __wakeup() {}
    
    public function run() {
        $rootServiceSpawner->spawnServices();
    }
}
