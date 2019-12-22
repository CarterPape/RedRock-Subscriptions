<?php

namespace RedRock\Subscriptions;

// If it turns out this doesn't need to be a service, rename it to QuotaTracker

class QuotaTrackingService extends Service {
    public function maybeInitQuotaTrackingForCurrentVisitor() {
        
    }
    
    public function emplaceCallbacks() {
        if (!isset($_COOKIE["articles-read"])) {
            
        }
        else {
            setcookie("");
        }
    }
}
