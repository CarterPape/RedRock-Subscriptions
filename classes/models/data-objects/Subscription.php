<?php

namespace RedRock\Subscriptions;

class Subscription extends Bean {
    public $ID;
    public $name;
    public $checkoutURL;
    public $renewalPeriod;
    public $priceInCents;
}
