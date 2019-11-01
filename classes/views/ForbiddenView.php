<?php

namespace RedRock\Subscriptions;

class PaywallView extends View {
    public function renderIt() {
        http_response_code(403);
        parent::renderIt();
    }
}
