<?php

function memberful_wp_plugin_activate() {
    add_option('memberful_wp_activation_redirect' , true);
}
register_activation_hook(__FILE__, 'memberful_wp_plugin_activate');

function memberful_wp_plugin_deactivate() {
    memberful_clear_cron_jobs();
}
register_deactivation_hook(__FILE__, 'memberful_wp_plugin_deactivate');
