<?php

namespace RedRock\Subscriptions;

class ContentProtectionService extends Service {
    public function emplaceCallbacks() {
        add_filter('the_content', array());
    }
}
