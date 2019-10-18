<?php

/**
 * Adaptions to core wordpress code that don't fit in other areas.
 *
 * Also includes other misc code.
 */

function memberful_wp_valid_nonce($action) {
    return isset($_POST['memberful_nonce']) && wp_verify_nonce($_POST['memberful_nonce'], $action);
}

function memberful_wp_nonce_field($action) {
    return wp_nonce_field($action, 'memberful_nonce');
}


function memberful_wp_render(
    $template,
    array $vars = array()
)
{
    extract($vars);

    include Plugin::defaultInstance()->getPluginDir().'/views/'.$template.'.php';
}
