<?php

namespace RedRock\Subscriptions;

class AssetLoadingService extends Service {
    public function emplaceCallbacks() {
        add_action("wp_enqueue_scripts",    array($this, "enqueueStyle"));
        add_action("wp_enqueue_scripts",    array($this, "enqueueZipCodeJS"));
        add_action("admin_enqueue_scripts", array($this, "enqueueAdminAssets"));
    }
    
    public function urlToRRSAsset($relativePath) {
        return plugins_url(
            $relativePath,
            Plugin::getDefinitions()->getPluginDir()
        );
    }
    
    function enqueueStyle() {
        wp_enqueue_style(
            'RRS general stylesheet',
            urlToRRSAsset('stylesheets/all.css')
        );
    }
    
    function enqueueZipCodeJS() {
        wp_enqueue_script(
            'RRS zip code input',
            urlToRRSAsset('js/zip code input.js'),
            array('jquery')
        );
    }
    
    function enqueueAdminAssets() {
         $screen = get_current_screen();

        if (strpos('memberful', $screen->id) !== null) {
            wp_enqueue_style(
                'RRS admin stylesheet',
                urlToRRSAsset('stylesheets/admin.css')
            );
            wp_enqueue_script(
                'RRS admin script',
                urlToRRSAsset('js/admin.js'),
                array('jquery'),
                Plugin::getDefinitions()->getPluginVersion()
            );
        }

        wp_enqueue_script(
            'RRS navigation menu script',
            urlToRRSAsset('js/menu.js'),
            array('jquery'),
            Plugin::getDefinitions()->getPluginVersion()
        );
    }
}
