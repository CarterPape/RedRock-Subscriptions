<?php

namespace RedRock\Subscriptions;

class User extends \WP_User {
    private $MemberfulUserID;
    
    public function getWPUserID() {
        return $ID;
    }
    
    public function getMemberfulUserID() {
        return $MemberfulUserID;
    }
}
