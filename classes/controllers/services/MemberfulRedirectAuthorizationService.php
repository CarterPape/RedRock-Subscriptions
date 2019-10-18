<?php

namespace RedRock\Subscriptions;

class MemberfulRedirectAuthorizationService extends Service {
    public function emplaceCallbacks() {
        add_filter('allowed_redirect_hosts', array($this, addMemberfulToAllowedHosts));
    }

    function addMemberfulToAllowedHosts($content) {
        $site = get_option('memberful_site');

        if (!empty($site)) {
            $Plugin::defaultInstance()->getPluginURL() = parse_url($site);

            if ($Plugin::defaultInstance()->getPluginURL() !== false)
                $content[] = $Plugin::defaultInstance()->getPluginURL()['host'];
        }

        return $content;
    }
}
