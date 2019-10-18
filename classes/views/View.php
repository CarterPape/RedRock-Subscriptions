<?php

namespace RedRock\Subscriptions;

abstract class View {
    protected $templateFileLocator = new TemplateFileLocator($this);
    protected $templateFilePath;
    
    public function renderIt() {
        if (!isset($templateFilePath)) {
            $templateFilePath = templateFileLocator->getTemplateFilePath();
        }
        
        include $templateFilePath;
    }
    
    public function returnIt() {
        ob_start();
        renderIt();
        return ob_get_clean();
    }
}
