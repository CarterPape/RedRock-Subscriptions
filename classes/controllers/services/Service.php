<?php

namespace RedRock\Subscriptions;

abstract class Service {
    public function emplaceCallbacks();
}

/*

An object that is a Service:
    0. Is one of the implementations of C (controller) in MVC.
    1. Expects to be constructed during plugin setup (in particular, very early in that process).
    2. Emplace callbacks of objects that may not necessarily be the Service implementation itself, e.g. filters, synchronizers, and view controllers. This action of emplacing callbacks provides appropriate objects (perhaps the Service implementation, itself) an opportunity to respond to other steps of WordPress setup.
    3. May invoke other Services (see: DependentService).

*/
