<?php

namespace RedRock\Subscriptions;

class RootServiceSpawner {
    private $serviceSuite;
    
    public function __construct($serviceSuite) {
        $this->serviceSuite = $serviceSuite;
    }
    
    public function spawnServices() {
        foreach ($serviceSuite->getAllServices() as $service) {
            $service->emplaceCallbacks();
        }
    }
}
