<?php

function memberful_wp_get_post_available_to_any_registered_users($post_id) {
    return get_post_meta($post_id, 'memberful_available_to_any_registered_user', TRUE) === "1";
}

function memberful_wp_set_post_available_to_any_registered_users($post_id, $is_viewable_by_any_registered_users) {
    update_post_meta($post_id, 'memberful_available_to_any_registered_user', $is_viewable_by_any_registered_users);
}

function redrock_subscriptions_get_free_posts() {
    global $wpdb;
    return wp_list_pluck($wpdb->get_results("SELECT post_id
                                FROM {$wpdb->prefix}postmeta
                                WHERE meta_key = 'memberful_available_to_any_registered_user'
                                AND meta_value = 1"), "post_id");
}
