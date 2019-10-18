<?php
$links = array(
    array(
        'id'    => 'memberful_connection',
        'title' => 'Memberful connection',
        'url'   => memberful_wp_plugin_settings_url()
    ),
    array(
        'id'    => 'content_protection',
        'title' => 'Content protection',
        'url'   => memberful_wp_plugin_bulk_protect_url()
    ),
    array(
        'id'    => 'role_mapping',
        'title' => 'Role mapping',
        'url'   => memberful_wp_plugin_advanced_settings_url()
    ),
    array(
        'id'    => 'cookies_test',
        'title' => 'Cookies test',
        'url'   => memberful_wp_plugin_cookies_test_url()
    ),
);
?>
<h2 class="nav-tab-wrapper">
<?php
    foreach ($links as $link) {
?>
        <a href="<?php echo $link['url']; ?>" id="nav_tab_<?php echo $link['id']; ?>" class="nav-tab <?php echo $link['id'] === $active ? 'nav-tab-active' : '' ?>"><?php echo $link['title']; ?></a>
<?php
    }
?>
</h2>
