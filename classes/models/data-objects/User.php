<?php

namespace RedRock\Subscriptions;

class User extends \WP_User {
    private $memberfulUserID    = null;
    private $guestID            = null;
    
    public function getWPUserID() {
        return $ID;
    }
    
    public function getMemberfulUserID() {
        return $memberfulUserID;
    }
}
