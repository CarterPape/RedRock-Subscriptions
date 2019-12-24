<?php

namespace RedRock\Subscriptions;

class ApplePayVerificationService extends Service {
    public function emplaceCallbacks() {
        add_action(
            "plugins_loaded",
            array(
                $this,
                "maybeServeApplePayDomainVerificationFile"
            )
        );
    }

    function maybeServeApplePayDomainVerificationFile() {
        if (
            $_SERVER["REQUEST_URI"]
            == "/.well-known/apple-developer-merchantid-domain-association"
        ) {
            readfile(
                Plugin::defaultInstance()->getPluginDir()
                . "/assets/apple-developer-merchantid-domain-association"
            );
            exit();
        }
    }
}
