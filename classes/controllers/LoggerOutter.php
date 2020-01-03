<?php

namespace RedRock\Subscriptions;

exit("incomplete implementation");

class LoggerOutter {
    private static $skipNextFinishingStep = false;
    
    private function exitEarlyToFinishLogout() {
        if (!memberful_wp_is_connected_to_site()) {
            return;
        }
        
        wp_safe_redirect(memberful_sign_out_url());
        exit();
    }
    
    public function handle_wp_logout() {
        if (self::$skipNextFinishingStep) {
            self::$skipNextFinishingStep = false;
            return;
        }
        else {
            $this->maybeExitEarlyToFinishLogout();
        }
    }
    
    public function maybeExitEarlyToFullyLogOut() {
        wp_logout();
        
        // The following call is redundant if an instance of this class is already hooked to the "wp_logout" action (as it is in many cases), but this method is meant to fully logs out the user and exits early, so the method below is called redundantly to guarantee it goes through.
        // If the method below is already hooked to the "wp_logout" action (which, again, is likely), all is well; the below call is not reached since the the program will have already exitted before getting here.
        
        $this->exitEarlyToFinishLogout();
    }
    
    function logOutFromWordPressOnly() {
        self::$skipNextFinishingStep = true;
        wp_logout();
    }
}
