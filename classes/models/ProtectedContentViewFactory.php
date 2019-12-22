<?php

namespace RedRock\Subscriptions;
 
// PHP type hinting should be used in the setView functions defined here to ensure that views are correctly subclassed.

class ProtectedContentViewFactory {
    // Also known as a factory that creates views of protected content
    private $requestedContent       = null;
    
    private $accountMessage         = null;
    private $unidentifiableMessage  = null;
}
