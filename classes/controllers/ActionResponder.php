<?php

namespace RedRock\Subscriptions;

abstract class ActionResponder {
    public function getActionTag();
    public function respondToAction();
}

/*

An object that is an ActionResponder:
    0. Is one of the implementations of C (controller) in MVC.
    1. Responds to one class of action (i.e. only one action name is mapped to an action responder).
    2. Is typically emplaced with WordPress' add_action.
    3. Does not emplace its own callback.
    4. May be a shell that simply invokes a service.

*/
