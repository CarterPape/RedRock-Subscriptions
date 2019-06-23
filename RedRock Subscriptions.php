<?php
/*
Plugin Name: RedRock Subscriptions
Description: Sell memberships and restrict access to content with WordPress and Memberful.
Author: The Times-Independent
Author URI: http://moabtimes.com/
*/

namespace RedRockSubscriptions;

class Plugin {
    private static $defaultInstance;
    private $pluginDefinitions;
    private $pluginSetterUpper;
    
    public static function _createDefaultInstance($pluginFile) {
        $defaultInstance = new Plugin();
        $defaultInstance->initAsDefault($pluginFile);
    }
    
    public static function defaultInstance() {
        return $defaultInstance;
    }
    
    private initAsDefault($pluginFile) {
        $pluginDefinitions = new PluginDefinitions($pluginFile);
        
        foreach (glob(getPluginDir() . "/classes/*.php") as $filename) {
            require_once $filename;
        }
        
        $pluginSetterUpper = new PluginSetterUpper();
    }
    
    
    public function init() {
        $pluginSetterUpper->doSetup();
    }
    
    public function shouldSSLVerify() {
        return $pluginDefinitions->shouldSSLVerify();
    }
    
    public function getEmbedHost() {
        return $pluginDefinitions->getEmbedHost;
    }
    
    public function getAppsHost() {
        return $pluginDefinitions->getAppsHost();
    }
    
    public function getPluginURL() {
        return $pluginDefinitions->getPluginURL();
    }
    
    public function getPluginDir() {
        return $pluginDefinitions->getPluginDir();
    }
    
    public function getPluginFile() {
        return $pluginDefinitions->getPluginFile();
    }
    
    public function getPluginVersion() {
        return $pluginDefinitions->getPluginVersion();
    }
}

class PluginDefinitions {
    public function __construct($pluginFile) {
        $this->pluginFile = $pluginFile;
        $pluginURL = plugins_url('', $pluginFile);
        $pluginDir = dirname($pluginFile);
    }
    
    private $pluginURL;
    private $pluginDir;
    private $pluginFile;
    private $shouldSSLVerify = true;
    private $embedHost = "https://d35xxde4fgg0cx.cloudfront.net";
    private $appsHost = "https://apps.memberful.com";
    private $pluginVersion = "1.48.0";
    
    public function shouldSSLVerify() {
        return $shouldSSLVerify;
    }
    
    public function getEmbedHost() {
        return $embedHost;
    }
    
    public function getAppsHost() {
        return $appsHost;
    }
    
    public function getPluginURL() {
        return $pluginURL;
    }
    
    public function getPluginDir() {
        return $pluginDir;
    }
    
    public function getPluginFile() {
        return $pluginFile;
    }
    
    public function getPluginVersion() {
        return $pluginVersion;
    }
}

Plugin::_createDefaultInstance(__FILE__);
Plugin::defaultInstance()->init();