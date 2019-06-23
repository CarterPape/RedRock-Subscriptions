<?php

class RRS_ApplePayVerifier {
    public function __construct() {
        add_action('plugins_loaded', array($this, 'show_apple_pay_domain_verification_file'));
    }

    function show_apple_pay_domain_verification_file() {
        if ($_SERVER["REQUEST_URI"] == "/.well-known/apple-developer-merchantid-domain-association") {
            readfile(MEMBERFUL_DIR . "/assets/apple-developer-merchantid-domain-association");
            exit();
        }
    }
}

new RRS_ApplePayVerifier;