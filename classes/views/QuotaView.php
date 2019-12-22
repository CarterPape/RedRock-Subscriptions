<?php

namespace RedRock\Subscriptions;

class QuotaView extends View {
    const kNewQuotaSnippet = 0x00;
    const kStillUnderQuotaSnippet = 0x01;
    
    private $message = "";
}
