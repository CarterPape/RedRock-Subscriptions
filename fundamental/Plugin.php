<?php

namespace RedRock\Subscriptions;

require_once "PluginDefinitions.php";
require_once "AutoLoader.php";
require_once "TimeZoneHandler.php";

class Plugin {
    private static $defaultInstance;
    
    private $pluginDefinitions;
    private $autoLoader;
    private $rootServiceSpawner;
    private $serviceSuite;
    
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
        return $defaultInstance->serviceSuite->getServiceByClass($class);
    }
    
    
    protected function __construct($pluginFile) {
        $pluginDefinitions = new PluginDefinitions($pluginFile);
        
        $timeZoneHandler = new TimeZoneHandler;
        $timeZoneHandler->handlePluginInitiation();
        
        $autoLoader = new AutoLoader;
        $audoLoader->hookAutoLoader();
        
        $serviceSuite = new ServiceSuite;
        $rootServiceSpawner = new RootServiceSpawner($serviceSuite);
    }
    
    public function run() {
        $rootServiceSpawner->spawnServices();
    }
}
