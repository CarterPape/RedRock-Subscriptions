<?php

namespace RedRock\Subscriptions;

class UserDBConnection extends DBConnection {
    private $user;
    
    private function makeOneMetaValueSingle($metaValue) {
        return maybe_unserialize($metaValue[0]);
    }
    
    private function getAllMeta() {
        $userMeta = array_map(
            array($this, "makeOneMetaValueSingle"),
            get_user_meta($user->getWPUserID())
        );
    }
}
