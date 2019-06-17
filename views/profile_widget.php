<?php

echo $before_widget
if (!empty($title)) {
        echo $before_title, $title, $after_title;
}
if (is_user_logged_in()) {

?>
    <div class="memberful-profile-gravatar">
        <?php echo get_avatar(wp_get_current_user()->user_email, 48); ?>
    </div>
    <div class="memberful-profile-info">
        <div class="memberful-profile-name">
<?php
            echo wp_get_current_user()->user_firstname . ' ' . wp_get_current_user()->user_lastname;
?>
        </div>
        <div class="memberful-profile-links">
            <?php echo memberful_wp_format_widget_links($signed_in_links); ?>
        </div>
    </div>
<?php

}
else {
    echo memberful_wp_format_widget_links($signed_out_links);
}
echo $after_widget;
