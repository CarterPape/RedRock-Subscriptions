<?php

namespace RedRock\Subscriptions;

class RoleMappingSubpage extends SettingsSubpage {
    public static function getSlug() {
        return "role_mapping";
    }
    
    public static function getNiceName() {
        return "Role mapping";
    }
    
    public function renderNonceField() {
        memberful_wp_nonce_field('memberful_options');
    }
