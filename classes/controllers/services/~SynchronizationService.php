<?php

namespace RedRock\Subscriptions;

// This is not needed because Memberful hits a specified server endpoint when it has a new member or subscription to add.

class SynchronizationService extends Service {
    private $subscriptionSynchronizer;// = new SubscriptionSynchronizer;
    private $memberSynchronizer;// = new MemberSynchronizer;
    
    public function emplaceCallbacks() {
        wp_schedule_event(time(), 'twicedaily', 'sync_with_memberful');

        add_action('sync_with_memberful', array($this, "syncUsers"));
        add_action('sync_with_memberful', array($this, "syncSubscriptions"));
    }
    
    function clearCronJobs() {
        wp_clear_scheduled_hook('sync_with_memberful');
    }

    function syncUsers() {
        set_time_limit(0);
        $memberSynchronizer->sync();
    }

    function syncSubscriptions() {
        set_time_limit(0);
        $subscriptionSynchronizer->sync();
    }
}
