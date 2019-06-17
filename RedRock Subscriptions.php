<?php
/*
Plugin Name: RedRock Subscriptions
Description: Sell memberships and restrict access to content with WordPress and Memberful.
Author: The Times-Independent
Author URI: http://moabtimes.com/
 */

if (! defined('MEMBERFUL_VERSION'))
    define('MEMBERFUL_VERSION', '1.48.0');

if (! defined('MEMBERFUL_PLUGIN_FILE'))
    define('MEMBERFUL_PLUGIN_FILE', __FILE__);

if (! defined('MEMBERFUL_DIR'))
    define('MEMBERFUL_DIR', dirname(__FILE__));

if (! defined('MEMBERFUL_URL'))
    define('MEMBERFUL_URL', plugins_url('', __FILE__));

if (! defined('MEMBERFUL_APPS_HOST'))
    define('MEMBERFUL_APPS_HOST', 'https://apps.memberful.com');

if (! defined('MEMBERFUL_EMBED_HOST'))
    define('MEMBERFUL_EMBED_HOST', 'https://d35xxde4fgg0cx.cloudfront.net');

if (! defined('MEMBERFUL_SSL_VERIFY'))
    define('MEMBERFUL_SSL_VERIFY', TRUE);

require_once MEMBERFUL_DIR . '/src/core-ext.php';
require_once MEMBERFUL_DIR . '/src/cron.php';
require_once MEMBERFUL_DIR . '/src/urls.php';
require_once MEMBERFUL_DIR . '/src/user/map.php';
require_once MEMBERFUL_DIR . '/src/user/meta.php';
require_once MEMBERFUL_DIR . '/src/user/role_decision.php';
require_once MEMBERFUL_DIR . '/src/authenticator.php';
require_once MEMBERFUL_DIR . '/src/admin.php';
require_once MEMBERFUL_DIR . '/src/admin/editor.php';
require_once MEMBERFUL_DIR . '/src/acl.php';
require_once MEMBERFUL_DIR . '/src/shortcodes.php';
require_once MEMBERFUL_DIR . '/src/widgets.php';
require_once MEMBERFUL_DIR . '/src/endpoints.php';
require_once MEMBERFUL_DIR . '/src/marketing_content.php';
require_once MEMBERFUL_DIR . '/src/content_filter.php';
require_once MEMBERFUL_DIR . '/src/entities.php';
require_once MEMBERFUL_DIR . '/src/embed.php';
require_once MEMBERFUL_DIR . '/src/api.php';
require_once MEMBERFUL_DIR . '/src/roles.php';
require_once MEMBERFUL_DIR . '/src/syncing.php';
require_once MEMBERFUL_DIR . '/src/logout_hooks.php';
require_once MEMBERFUL_DIR . '/vendor/reporting.php';
require_once MEMBERFUL_DIR . '/src/private_user_feed.php';
require_once MEMBERFUL_DIR . '/src/comments_protection.php';
require_once MEMBERFUL_DIR . '/src/nav_menus.php';

if (in_array('sensei/woothemes-sensei.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    require_once MEMBERFUL_DIR . '/src/contrib/woothemes-sensei.php';
}

if (in_array('sfwd-lms/sfwd_lms.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    require_once MEMBERFUL_DIR . '/src/contrib/sfwd-learndash.php';
}

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    require_once MEMBERFUL_DIR . '/src/contrib/woocommerce.php';
}

if (in_array('elementor/elementor.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    require_once MEMBERFUL_DIR . '/src/contrib/elementor.php';
}

if (in_array('wp-ultimate-recipe/wp-ultimate-recipe.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    require_once MEMBERFUL_DIR . '/src/contrib/wp-ultimate-recipe.php';
}

if (in_array('wp-ultimate-recipe-premium/wp-ultimate-recipe-premium.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    require_once MEMBERFUL_DIR . '/src/contrib/wp-ultimate-recipe-premium.php';
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
    } else {
        return $expireIn;
    }
}
add_filter('auth_cookie_expiration', 'memberful_extend_auth_cookie_expiration');
