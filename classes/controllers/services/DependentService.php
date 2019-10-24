<?php

namespace RedRock\Subscriptions;

abstract class DependentService extends Service {
    public abstract function takeDependencies($allServicesByClass);
}
