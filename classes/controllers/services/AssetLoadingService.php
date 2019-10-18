<?php

namespace RedRock\Subscriptions;

class AssetLoadingService extends Service {
    public function emplaceCallbacks() {
        add_action("wp_enqueue_scripts",    array($this, "enqueueStyle"));
        add_action("wp_enqueue_scripts",    array($this, "enqueueZipCodeJS"));
        add_action("admin_enqueue_scripts", array($this, "enqueueAdminAssets"));
    }
    
    function enqueueStyle() {
        wp_enqueue_style(
            'memberful-admin',
            plugins_url('stylesheets/all.css')
        );
    }
    
    function enqueueZipCodeJS() {
        wp_enqueue_script(
            'RRS zip code input',
            plugins_url('js/zip code input.js'),
            array('jquery')
        );
    }
    
    function enqueueAdminAssets() {
         $screen = get_current_screen();

        if (strpos('memberful', $screen->id) !== null) {
            wp_enqueue_style(
                'memberful-admin',
                plugins_url('stylesheets/admin.css' , Plugin::getDefinitions()->getPluginDir())
            );
            wp_enqueue_script(
                'memberful-admin',
                plugins_url('js/admin.js', Plugin::getDefinitions()->getPluginDir()),
                array('jquery'),
                Plugin::getDefinitions()->getPluginVersion()
            );
        }

        wp_enqueue_script(
            'memberful-menu',
            plugins_url('js/menu.js', Plugin::getDefinitions()->getPluginDir()),
            array('jquery'),
            Plugin::getDefinitions()->getPluginVersion()
        );
    }
}
