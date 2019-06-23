<?php

namespace RedRockSubscriptions;

abstract class View {
    protected $templatePartsDir = Plugin::defaultInstance()->getPluginDir();
    
    public function echo() {
        include $templatePartsDir . "/" . get_class($this) . ".template.php";
    }
    
    public function returnView() {
        ob_start();
        show();
        return ob_get_clean();
    }
}