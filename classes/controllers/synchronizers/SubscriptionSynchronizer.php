<?php


    private $logger = new Logger($this);

        logger.log(__METHOD__, __LINE__, "Beginning sync of " . count($membersToSync) . " members from a cron job.");
        
        memberful_wp_sync_subscription_plans();

        logger.log(__METHOD__, __LINE__, "Finished syncing " . count($membersToSync) . " members from a cron job.");
