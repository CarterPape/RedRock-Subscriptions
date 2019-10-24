<?php

namespace RedRock\Subscriptions;

class ClassLoader {
    private $subdirectoryPathRelativeToPluginDirectory;
    private $loadedClasses = array();
    
    private $namespace;
    private $classShortName;
    private $gettingNamespace;
    private $gettingClass;
    
    public function __construct($subdirectoryPathRelativeToPluginDirectory) {
        $this->subdirectoryPathRelativeToPluginDirectory = $subdirectoryPathRelativeToPluginDirectory;
    }
    
    public function loadClasses() {
        includeAllFilesInDirectory();
        return $loadedClasses;
    }
    
    private function includeAllFilesInDirectory() {
        $absoluteDirectoryPath =
            Plugin::getDefinitions()->getPluginDirectoryPath()
            . $subdirectoryPathRelativeToPluginDirectory;
        
        recursivelyIncludeFiles($absoluteDirectoryPath);
    }
    
    private function recursivelyIncludeFiles($absoluteDirectoryPath) {
        $allAbsoluteSubpaths = glob($absoluteDirectoryPath . "*", GLOB_MARK);
        
        foreach ($allAbsoluteSubpaths as $eachAbsoluteSubpath) {
            if (is_dir($eachSubpath)) {
                recursivelyIncludeFiles($eachAbsoluteSubpath);
            }
            else if (pathinfo($eachAbsoluteSubpath, PATHINFO_EXTENSION) == "php") {
                $foundClass = getQualifiedClassNameDefinedAtPath($eachAbsoluteSubpath);
                $loadedClasses[] = $foundClass;
                $skipAutoload = true;
                
                if (!class_exists($foundClass, !$skipAutoload)) {
                    include $eachAbsoluteSubpath;
                }
            }
        }
    }
    
    private function getQualifiedClassNameDefinedAtPath($absoluteFilePath) {
        $fileContents = file_get_contents($absoluteFilePath);
        
        $namespace = "";
        $classShortName = "";
        $gettingNamespace = false;
        $gettingClass = false;

        foreach (token_get_all($fileContents) as $currentToken) {
            processToken();
            
            if ($classShortName !== "") {
                break;
            }
        }

        return $namespace !== ""
            ? $namespace . "\\" . $class
            : $classShortName;
    }
    
    private function processToken() {
        if (
            is_array($currentToken)
            && $currentToken[0] == T_NAMESPACE
        ) {
            $gettingNamespace = true;
            return;
        }
        
        if (
            is_array($currentToken)
            && $currentToken[0] == T_CLASS
        ) {
            $gettingClass = true;
            return;
        }

        if ($gettingNamespace === true) {
            if (
                is_array($currentToken)
                && in_array($currentToken[0], [T_STRING, T_NS_SEPARATOR])
            ) {
                $namespace .= $currentToken[1];
            }
            else if ($currentToken === ";") {
                $gettingNamespace = false;
            }
        }

        if ($gettingClass === true) {
            if (
                is_array($currentToken)
                && $currentToken[0] == T_STRING
            ) {
                $classShortName = $currentToken[1];
            }
        }
    }
}
