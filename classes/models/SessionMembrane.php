<?php

namespace RedRock\Subscriptions;

/*
    SessionMembrane instances gather information from WordPress and pair it with parallel information from this plugin. Raw data is part of the session; this includes the identity of the user being served (identified by a RedRock\Subscriptions\User object), information about the story currently being accessed, the content of specified cookies, and others.
    
    Interpreted data is not part of the session; instances of this class do not on their own answer questions such whether the current user, given the current page, is allowed to access the content.
    
    It is not a model element cannot interpret data in this way; it is that interpreting session data is outside of the scope of what a session is and does.
*/

class SessionScout {
    public function getCurrentUser() {
        
    }
}
