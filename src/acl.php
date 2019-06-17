<?php
require_once MEMBERFUL_DIR . '/src/acl/helpers.php';
require_once MEMBERFUL_DIR . '/src/acl/free_membership.php';

/**
 * Determines the set of post IDs that the current user cannot access
 *
 * If a page/post requires access to two downloads (a and or b), then the user will be granted access to the content if they have bought access to either download a or b.
 *
 * TODO: This is calculated on every page load, maybe use a cache?
 *
 * @return array Map of post ID => post ID
 */
function memberful_wp_user_disallowed_post_ids($user_id) {
    static $ids = array();

    $user_id        = (int) $user_id;
    $user_signed_in = $user_id !== 0;

    if (isset($ids[$user_id])) {
        return $ids[$user_id];
    }

    $global_download_acl             = isset($acl['download']) ? $acl['download'] : array();
    $global_subscription_acl        = isset($acl['subscription']) ? $acl['subscription'] : array();
    $posts_for_any_registered_users = redrock_subscriptions_get_free_posts();

    // Items the user has access to
    $user_downloads = memberful_wp_user_downloads($user_id);
    $user_subs     = memberful_wp_user_plans_subscribed_to($user_id);

    // Work out the set of posts the user is and isn't allowed to access
    $user_download_acl      = memberful_wp_generate_user_specific_acl_from_global_acl($user_downloads, $global_download_acl);
    $user_subscription_acl = memberful_wp_generate_user_specific_acl_from_global_acl($user_subs, $global_subscription_acl);

    $user_allowed_posts    = array_merge($user_download_acl['allowed'],    $user_subscription_acl['allowed']);
    
    $user_restricted_posts = array_merge($user_download_acl['restricted'], $user_subscription_acl['restricted'], $posts_for_any_registered_users);
    
    $posts_user_is_not_allowed_to_access = array_diff($user_restricted_posts, $user_allowed_posts);

    if ($user_signed_in) {
        $posts_user_is_not_allowed_to_access = array_diff($posts_user_is_not_allowed_to_access, $posts_for_any_registered_users);
    }

    return $ids[$user_id] = (empty($posts_user_is_not_allowed_to_access) ? array() : array_combine($posts_user_is_not_allowed_to_access, $posts_user_is_not_allowed_to_access));
}

/**
 * Given a set of downloads/subscriptions that the member has, and the corresponding
 * download/subscription acl for the site, work out what posts they can view.
 *
 * @param  array $users_entities An array of ids (either download ids or subscription ids) in form id => id.
 * @param  array $acl            Global acl for the entity type.
 * @return
 */
function memberful_wp_generate_user_specific_acl_from_global_acl($users_entities, $acl) {
    if (empty($users_entities))
        $users_entities = array();

    $allowed_entities    = array_intersect_key($acl, $users_entities);
    $restricted_entities = array_diff_key($acl, $users_entities);

    $allowed_ids    = array();
    $restricted_ids = array();

    foreach ($allowed_entities as $posts) {
        $allowed_ids = array_merge($allowed_ids, $posts);
    }

    foreach ($restricted_entities as $posts) {
        $restricted_ids = array_merge($restricted_ids, $posts);
    }

    // array_merge doesn't preserve keys
    $allowed    = array_unique($allowed_ids);
    $restricted = array_unique($restricted_ids);

    return array('allowed' => $allowed, 'restricted' => $restricted);
}

/**
 * Gets the array of downloads the member with $member_id owns
 *
 * @return array member's downloads
 */
function memberful_wp_user_downloads($user_id) {
    return get_user_meta($user_id, 'memberful_download', TRUE);
}

/**
 * Gets the plans that the member with $member_id is currently subscribed to
 * If the member had a subscription to a plan, but it has expired then it
 * is not included in this list.
 *
 * @return array member's subscriptions
 */
function memberful_wp_user_plans_subscribed_to($user_id) {
    return get_user_meta($user_id, 'memberful_subscription', TRUE);
}

/**
 * Gets the download the current member has
 *
 * @return array current member's downloads
 */
function memberful_wp_current_user_downloads() {
    $current_user = wp_get_current_user();
    return memberful_wp_user_downloads($current_user->ID);
}

/**
 * Check that the specified user is subscribed to at least one of the specified plans
 *
 * @param int   $user_id The id of the wordpress user
 * @param array $subscriptions Ids of the subscriptions to restrict access to
 * @return boolean
 */
function memberful_wp_user_has_subscription_to_plans($user_id, array $required_plans) {
    $plans_user_is_subscribed_to = memberful_wp_user_plans_subscribed_to($user_id);

    foreach ($required_plans as $plan) {
        if (isset($plans_user_is_subscribed_to[ $plan ])) {
            return TRUE;
        }
    }

    return FALSE;
}

/**
 * Check that the specified user has at least one of a set of downloads
 *
 * @param int   $user_id   The id of the wordpress user
 * @param array $downloads Ids of the downloads to check the user has
 * @return boolean
 */
function memberful_wp_user_has_downloads($user_id, $required_downloads) {
    $downloads_user_has = memberful_wp_user_downloads($user_id);

    foreach ($required_downloads as $download) {
    if (isset($downloads_user_has[ $download ]))
        return TRUE;
    }

    return FALSE;
}

/**
 * Extracts ids, and a user ID from the arguments passed to one of the
 * has_memberful_* helpers.
 *
 * @param array $args ALL arguments passed to the original helper
 * @return array      Array of IDs extract from the slugs as first element, user id as second
 */
function memberful_wp_extract_slug_ids_and_user($args) {
    $slugs = $args[0];
    $user  = empty($args[1]) ? NULL : $args[1];

    if ($user === NULL)
        $user = wp_get_current_user()->ID;

    return array(memberful_wp_slugs_to_ids($slugs), $user);
}

/**
 * Checks that the user has permission to access the specified post
 *
 * @param integer $user_id ID of the user
 * @param integer $post_id ID of the post that should have access checked
 */
function memberful_can_user_access_post($user, $post) {
    $restricted_posts = memberful_wp_user_disallowed_post_ids($user);

    return ! isset($restricted_posts[$post]);
}
