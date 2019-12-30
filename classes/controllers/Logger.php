<?php

namespace RedRock\Subscriptions;

class Logger {
    private $callingObject;
    private $callingFile;
    private $currentMethod;
    private $currentLineNumber;
    
    public function __construct(
        $callingObject,
        $callingFile
    ) {
        $this->callingObject = $callingObject;
        $this->callingFile = $callingFile;
    }
    
    public function simpleLog(
        $message,
        $includePayload = false
    ) {
        $logOutput = "from {$callingFile}: {$message}";
        $logOutput .=
            $includePayload
                ? "\n\n" . payload()
                : "";
        
        error_log("from {$callingFile}: ${message}");
    }
    
    public function verboseLog(
        $currentMethod,
        $currentLineNumber,
        $message,
        $includePayload = false
    ) {
        $this->currentLineNumber = $currentLineNumber;
        $this->currentMethod = $currentMethod;
        
        $logOutput = verboseSourceInfo() . "\n" . $message;
        $logOutput .=
            $includePayload
                ? "\n\n" . payload()
                : "";
        
        error_log($logOutput);
    }
    
    private function verboseSourceInfo() {
        return "from {$callingFile} in {$currentMethod}, line #{$currentLineNumber}:";
    }
    
    private function payload() {
        return "via calling object:\n" . var_dump($callingObject);
    }
}
