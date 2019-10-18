<?php

class MemberSynchronizer implements Synchronizer {
    private $logger = new Logger($this);
    private $userMappingRepository = new UserMappingRepository;
    private $membersToSync;
    
    public function sync() {
        logStart(__METHOD__, __LINE__);
        $membersToSync = $userMappingRepository->fetchIDsOfMembersThatNeedSyncing();
        logCount();
        foreach ($membersToSync as $memberfulMember) {
            $wpUserID = memberful_wp_sync_member_from_memberful($memberfulMember);
            logMemberSynced($memberfulMember, $wpUserID);
        }
        logEnd(__METHOD__, __LINE__);
    }
    
    private function logStart($callingMethod, $callingLine) {
        logger.verboseLog(
            $callingMethod,
            $callingLine,
            "Beginning member sync from a cron job."
        );
    }
    
    private function logCount() {
        logger.simpleLog("Found ". count($membersToSync) . " members to sync.");
    }
    
    private function logMemberSynced($memberfulID, $wpUserID) {
        logger.simpleLog("Connected Memberful member #". $memberfulMember->ID . " to WordPress user #" . $wpUser->ID . ".");
    }
    
    private function logEnd($callingMethod, $callingLine) {
        logger.verboseLog(
            $callingMethod,
            $callingLine,
            "Finished syncing " . count($membersToSync) . " members from a cron job."
        );
    }
}
