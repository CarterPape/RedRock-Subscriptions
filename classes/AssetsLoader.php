<?php

namespace RedRockSubscriptions;

class AssetsLoader implements DoesPluginSetup {
    function doPluginSetup() {
        add_action("wp_enqueue_scripts", array(this, "enqueueStyle");
        add_action("wp_enqueue_scripts", array(this, "enqueueZipCodeJS");
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
}