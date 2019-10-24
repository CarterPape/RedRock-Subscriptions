<?php

namespace RedRock\Subscriptions;

/*
    A ContentProtectionService instance is a service. It is reponsible for protecting content on the website. The service protects content by withholding it from the user unless the service can prove the user may access it.
    
    Part of protecting content is replacing it with marketing material when it is withheld and, perhaps, notifying the user of the number of free articles left.
    
    It is key to, as much as possible, minimize interruption of active subscribers' access to content. This service should be optimized to serve them first.
*/

class ContentProtectionService extends Service {
    private $contentAccesssCircumstances = null;
    
    public function emplaceCallbacks() {
        add_filter('the_content', array($this, "maybeGutContent"));
    }
    
    public function maybeGutContent() {
        checkWhetherCurrentUserMayAccess();
        
        if ($currentUserMayAccess) {
            
        }
        else {
            
        }
    }
    
    public function checkWhetherCurrentUserMayAccess() {
        
    }
}
