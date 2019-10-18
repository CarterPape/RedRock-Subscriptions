<?php

namespace RedRock\Subscriptions;

class AutoLoader {
    private $classesDirectory;
    private $currentClass;
    private $currentClassShortname;
    
    public function __construct() {
        $classesDirectory =
            Plugin::getDefinitions()->getPluginDirectoryPath()
            . "/classes/";
    }
    
    public function hookAutoLoader() {
        spl_autoload_register(array($this, "autoLoad"));
    }
    
    private function autoLoad($class) {
        $currentClass = $class;
        $currentClassShortname = getClassShortName($class);
        
        loadRecursivelyFromDirectory($classesDirectory);
    }
    
    private function loadRecursivelyFromDirectory($dir) {
        $thePossibleTarget = $dir . $classShortName . ".php";
        
        if (file_exists($thePossibleTarget)) {
            include $thePossibleTarget;
            
            return TRUE;
        }
        
        $subDirectories = glob($dir . "*", GLOB_ONLYDIR | GLOB_MARK);
        
        foreach ($subDirectories as $subDirectory) {
            $loaded = loadRecursivelyFromDirectory($subDirectory);
            
            if ($loaded) {
                return TRUE;
            }
        }
        
        return FALSE;
    }
    
    private function getClassShortName($class) {
        $array = explode('\\', $class);
        return end($array);
    }
}
