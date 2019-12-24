<?php

namespace RedRock\Subscriptions;

class MemberfulRedirectAuthorizationService extends Service {
    public function emplaceCallbacks() {
        add_filter(
            "allowed_redirect_hosts",
            array(
                $this,
                "addMemberfulToAllowedHosts"
            )
        );
    }
    
    public function addMemberfulToAllowedHosts($allowedHosts) {
        $site = get_option("memberful_site");

        if (!empty($site)) {
            $parsedMemberfulSite = wp_parse_url($site);

            if ($parsedMemberfulSite !== false) {
                $allowedHosts[] = $$parsedMemberfulSite["host"];
            }
        }
        
        return $allowedHosts;
    }
}
