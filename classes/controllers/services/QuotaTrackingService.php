<?php

namespace RedRock\Subscriptions;

class FreeReadTrackingService extends Service {
    private $freeReadCountCookieName;
    private $clientFreeReadCount;
    private $clientFreeReadQuota;
    private $clientFreeReadCountAlreadyIncremented;
    
    private $settingsDBConnection;
    
    public function __construct() {
        $clientFreeReadCountAlreadyIncremented = false;
        
        $freeReadCountCookieName =
            Plugin::getDefinitions()->getPluginCookiePrefix()
            . "FreeReadCount";
        
        $settingsDBConnection = new SettingsDBConnection;
    }
    
    public function emplaceCallbacks() {
        add_action(
            "plugins_loaded",
            array(
                $this,
                "getFreeReadInfoForCurrentClient"
            )
        );
    }
    
    public function getFreeReadInfoForCurrentClient() {
        if (!isset($_COOKIE[$freeReadCountCookieName])) {
            setFreeReadCount(0);
        }
        
        $clientFreeReadCount = intval($_COOKIE[$freeReadCountCookieName]);
        $clientFreeReadQuota
            = $settingsDBConnection
                ->getSetting("RRS_universal_free_reads_quota");
    }
    
    public function requesterIsBelowFreeReadQuota() {
        return $clientFreeReadCount < $clientFreeReadQuota;
    }
    
    public function conservativelyIncrementRequesterFreeReadCount() {
        if (!self::$clientFreeReadCountAlreadyIncremented) {
            setFreeReadCount($clientFreeReadCount + 1);
            self::$clientFreeReadCountAlreadyIncremented = true;
        }
    }
    
    private function setFreeReadCount(int $freeReadCount) {
        $whenToResetFreeReadCount   = strtotime("first day of next month");
        
        $pathsAllowedToAccessTheCookie          = "/"; // (i.e. all of them)
        $subdomainsAllowedToAccessTheCookie     = "$_SERVER[HTTP_HOST]";
            // (i.e. all of them)
        
        $transmitTheCookieSecurely              = false;
        $makeTheCookieAccessibleOnlyViaHTTP     = false;
        
        setcookie(
            $freeReadCountCookieName,
            strval($freeReadCount),
            $whenToResetFreeReadCount,
            $allowAllPathsToAccessTheCookie,
            $allowAllSubdomainsToAccessTheCookie,
            $transmitTheCookieSecurely,
            $makeTheCookieAccessibleOnlyViaHTTP
        );
    }
}
