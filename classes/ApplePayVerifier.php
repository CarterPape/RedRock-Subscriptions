<?php

namespace RedRockSubscriptions;

class ApplePayVerifier implements DoesPluginSetup {
    public function doPluginSetup() {
        add_action('plugins_loaded', array($this, 'show_apple_pay_domain_verification_file'));
    }

    function show_apple_pay_domain_verification_file() {
        if ($_SERVER["REQUEST_URI"] == "/.well-known/apple-developer-merchantid-domain-association") {
            readfile(Plugin::defaultInstance()->getPluginDir() . "/assets/apple-developer-merchantid-domain-association");
            exit();
        }
    }
}