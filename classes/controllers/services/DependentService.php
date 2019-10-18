<?php

namespace RedRock\Subscriptions;

abstract class DependentService extends Service {
    public function takeDependencies($allServicesByClass);
}
