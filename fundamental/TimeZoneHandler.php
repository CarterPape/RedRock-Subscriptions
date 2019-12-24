<?php

namespace RedRock\Subscriptions;

// Aren't time zones just awful and needlessly complicating?

class TimeZoneHandler {
    public function handlePluginInitiation() {
        $defaultTimezone = "America/Denver"; // The center of the world
        $timezone = $defaultTimezone;
    
        // On many systems (Macs, for instance), "/etc/localtime" is a symlink to a file with the timezone info.
        if (is_link("/etc/localtime")) {
            
            // In this case, the file's name contains the timezone in Olson format.
            $filename = readlink("/etc/localtime");
            
            $pos = strpos($filename, "/zoneinfo/");
            if ($pos) {
                // The timezone is expected after the "/zoneinfo/" part of the path.
                $timezone = substr($filename, $pos + strlen("/zoneinfo/"));
            }
        }
        else {
            // On other systems, there is a file that contains the timezone in Olson format.
            $timezone = file_get_contents("/etc/timezone");
            if (!strlen($timezone)) {
                $timezone = $defaultTimezone;
            }
        }
        
        date_default_timezone_set($timezone);
    }
}
