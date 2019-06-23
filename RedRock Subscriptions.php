<?php
/*
Plugin Name: RedRock Subscriptions
Description: Sell memberships and restrict access to content with WordPress and Memberful.
Author: The Times-Independent
Author URI: http://moabtimes.com/
 */

if (!defined('MEMBERFUL_VERSION'))
    define('MEMBERFUL_VERSION', '1.48.0');

if (!defined('MEMBERFUL_PLUGIN_FILE'))
    define('MEMBERFUL_PLUGIN_FILE', __FILE__);

if (!defined('MEMBERFUL_DIR'))
    define('MEMBERFUL_DIR', dirname(__FILE__));

if (!defined('MEMBERFUL_URL'))
    define('MEMBERFUL_URL', plugins_url('', __FILE__));

if (!defined('MEMBERFUL_APPS_HOST'))
    define('MEMBERFUL_APPS_HOST', 'https://apps.memberful.com');

if (!defined('MEMBERFUL_EMBED_HOST'))
    define('MEMBERFUL_EMBED_HOST', 'https://d35xxde4fgg0cx.cloudfront.net');

if (!defined('MEMBERFUL_SSL_VERIFY'))
    define('MEMBERFUL_SSL_VERIFY', TRUE);

foreach (glob(MEMBERFUL_DIR . "/src/*.php") as $filename) {
    require_once $filename;
}

require_once MEMBERFUL_DIR . '/vendor/reporting.php';

foreach (glob(MEMBERFUL_DIR . "/classes/*.php") as $filename) {
    require_once $filename;
}

function memberful_wp_plugin_activate() {
    add_option('memberful_wp_activation_redirect' , true);
}
register_activation_hook(__FILE__, 'memberful_wp_plugin_activate');

function memberful_wp_plugin_deactivate() {
    memberful_clear_cron_jobs();
}
register_deactivation_hook(__FILE__, 'memberful_wp_plugin_deactivate');

function memberful_extend_auth_cookie_expiration($expireIn) {
    if (get_option('memberful_extend_auth_cookie_expiration')) {
        return WEEK_IN_SECONDS * 8;
    }
    else {
        return $expireIn;
    }
}
add_filter('auth_cookie_expiration', 'memberful_extend_auth_cookie_expiration');
