<?php

namespace RedRock\Subscriptions;

class ForbiddenView extends View {
    const kPrivateSessionSnippet    = 0x00;
    const kHitFreeQuotaSnippet      = 0x01;
    
    public function renderInPlace() {
        http_response_code(403);
        parent::renderInPlace();
    }
}
