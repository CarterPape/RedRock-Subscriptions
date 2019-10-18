<?php

/**
 * Check that the current member has a subscription to at least least one of the required plans
 *
 * @param string|array $slug    Slug of the plan the user should have. Can pass an array of slugs
 * @param int          $user_id ID of the user who should have the subscription, defaults to current user
 * @return bool
 */
function is_subscribed_to_memberful_plan($slug, $user_id = NULL) {
    list($required_plans , $user_id) = memberful_wp_extract_slug_ids_and_user(func_get_args());

    return memberful_wp_user_has_subscription_to_plans($user_id, $required_plans);
}

/**
 * Check that the current member has access to at least one of the specified downloads
 *
 * @param string|array $slug    Slug of the download the user should have. Can pass an array of slugs
 * @param int          $user_id ID of the user who should have the download, defaults to current user
 * @return bool
 */
function has_memberful_download($slug, $user_id = NULL) {
    list($required_downloads, $user_id) = memberful_wp_extract_slug_ids_and_user(func_get_args());

    return memberful_wp_user_has_downloads($user_id, $required_downloads);
}

function memberful_wp_posts_that_are_protected() {
    static $post_ids = NULL;

    if ($post_ids !== NULL) {
        return $post_ids;
    }

    $global_acl = get_option('memberful_acl');
    $post_ids   = array();

    // Loops in loops aren't good, but at least we cache this with the static call
    foreach($global_acl as $entity_type => $acl) {
        foreach($acl as $purchasable_id => $posts_this_item_grants_access_to) {
            $post_ids = array_merge($post_ids, array_values($posts_this_item_grants_access_to));
        }
    }

    $post_ids = array_unique($post_ids);

    return empty($post_ids) ? array() : $post_ids;
}
