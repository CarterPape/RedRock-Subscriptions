<?php

namespace RedRock\Subscriptions;

abstract class View {
    protected $templateFileLocator;
    protected $templateFilePath;
    
    public function __construct() {
        $templateFileLocator = new TemplateFileLocator($this);
    }
    
    public function renderIt() {
        if (!isset($templateFilePath)) {
            $templateFilePath = $templateFileLocator.getTemplateFilePath();
        }
        
        include $templateFilePath;
    }
    
    public function returnIt() {
        ob_start();
        renderIt();
        return ob_get_clean();
    }
}
