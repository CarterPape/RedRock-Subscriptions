<?php

namespace RedRock\Subscriptions;

class InconsistentAccessContextException extends Exception {
    public function __construct($culprit) {
        $message = "Inconsistent access context. Unable to evaluate '$culprit'";
        $code = 1;
        
        parent::__construct($message, $code);
    }
}
