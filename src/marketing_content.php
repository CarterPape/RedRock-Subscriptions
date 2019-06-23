<?php

function memberful_marketing_content($post_id) {
    $paywallView = new RRS_PaywallView();
    return apply_filters('memberful_marketing_content', $paywallView);
}

function memberful_wp_marketing_content_explanation() {
    return "This marketing content will be shown to anyone who is not allowed to read the post below a preview of your protected content...";
}
