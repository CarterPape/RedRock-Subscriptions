<?php

namespace RedRock\Subscriptions;

// Also known as a factory that creates views of protected content

class ProtectedContentViewFactory {
    private $requestedContent       = null;
    
    private $accountMessage         = null;
    private $unidentifiableMessage  = null;
}
