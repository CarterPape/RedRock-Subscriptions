<?php

namespace RedRock\Subscriptions;

class ServiceSuite {
    private static $servicesDirectoryPathRelativeToPluginDirectory
        = "./classes/controllers/services/";
    
    private $services           = array();
    private $dependentServices  = array();
    private $serviceClassLoader;
    
    public function __construct() {
        $serviceClassLoader
            = new ClassLoader(
                $servicesDirectoryPathRelativeToPluginDirectory
            );
        
        $serviceClassList = $serviceClassLoader->loadClasses();
        
        foreach ($serviceClassList as $eachClass) {
            maybeAddToServiceLists($eachClass);
        }
        
        hookDependentServices();
    }
    
    private function maybeAddToServiceLists($class) {
        if (is_subclass_of($class, Service::class)) {
            $services[$class] = new $class;
            
            if (is_subclass_of($class, DependentService::class)) {
                $dependentServices[$class] = $services[$class];
            }
        }
    }
    
    private function hookDependentServices() {
        foreach ($dependentServices as $dependentService) {
            $dependentService->takeDependencies($services);
        }
    }
    
    public function getServiceByClass($class) {
        return $services[$class];
    }
    
    public function getAllServices() {
        return $services;
    }
}
