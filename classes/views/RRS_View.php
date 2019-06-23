<?php

abstract class RRS_View {
    protected $templatePartsDir = MEMBERFUL_DIR;
    
    public function show() {
        include $templatePartsDir . "/" . get_class($this) . ".template.php";
    }
    
    public function returnView() {
        ob_start();
        show();
        return ob_get_clean();
    }
}