<?php

namespace RedRock\Subscriptions;

class PluginDefinitions {
    private $pluginURL;
    private $pluginDirectoryPath;
    private $pluginFile;
    private $shouldSSLVerify = true;
    private $embedHost = "https://d35xxde4fgg0cx.cloudfront.net";
    private $appsHost = "https://apps.memberful.com";
    private $pluginVersion = "1.48.0";
    private $pluginName = "RedRock Subscriptions";
    
    public function __construct($pluginFile) {
        $this->pluginFile = $pluginFile;
        $pluginURL = plugins_url('', $pluginFile);
        $pluginDirectoryPath = dirname($pluginFile);
    }
    
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
    
    public function getPluginDirectoryPath() {
        return $pluginDirectoryPath;
    }
    
    public function getPluginFile() {
        return $pluginFile;
    }
    
    public function getPluginVersion() {
        return $pluginVersion;
    }
    
    public function getPluginName() {
        return $pluginName;
    }
}
