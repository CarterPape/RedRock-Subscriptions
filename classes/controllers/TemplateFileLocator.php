<?php

namespace RedRock\Subscriptions;

class TemplateFileLocator {
    private $templateFilePath;
    
    public function __construct($parentView) {
        $templateFilePath = locateTemplateFileForViewObject($parentView);
    }
    
    private function locateTemplateFileForViewObject($view) {
        $reflectionClass        = new \ReflectionClass($view);
        $viewFile               = $reflectionClass->getFileName();
        $templatesDir           = dirname($viewFile) . "/templates/";
        $templateFileBaseName   = pathinfo($viewFile, PATHINFO_FILENAME) . ".template.php";
        
        return $templatesDir . $templateFileBaseName;
    }
    
    public function getTemplateFilePath() {
        return $templateFilePath;
    }
    
    /*
    
    public function __construct($viewObject) {
        $templatePartsDir   = Plugin::getDefinitions()->getPluginDir() . "/template-parts/";
        $templateFileName   = getShortClassName($viewObject) . ".template.php";
        locateRecursivelyInDirectory($templatePartsDir);
    }
    
    private static function getShortClassName($object) {
        $reflectionClass = new \ReflectionClass($object);
        return $reflectionClass->getShortName();
    }
    
    private function locateRecursivelyInDirectory($dir) {
        $thePossiblePath = $dir . $templateFileName;
        
        if (file_exists($thePossiblePath)) {
            $templateFilePath = $thePossiblePath;
            
            return TRUE;
        }
        
        $subDirectories = glob($dir . "*", GLOB_ONLYDIR | GLOB_MARK);
        
        foreach ($subDirectories as $subDirectory) {
            $loaded = locateRecursivelyInDirectory($subDirectory);
            
            if ($loaded) {
                return TRUE;
            }
        }
        
        return FALSE;
    }
    
    */
}
