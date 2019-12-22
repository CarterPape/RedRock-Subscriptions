<?php

namespace RedRock\Subscriptions;

abstract class View {
    protected $templateFileLocator;
    protected $templateFilePath;
    
    public function __construct() {
        $templateFileLocator = new TemplateFileLocator($this);
    }
    
    public function renderInPlace() {
        if (!isset($templateFilePath)) {
            $templateFilePath = $templateFileLocator.getTemplateFilePath();
        }
        
        include $templateFilePath;
    }
    
    public function renderAsString() {
        ob_start();
        renderInPlace();
        return ob_get_clean();
    }
}
