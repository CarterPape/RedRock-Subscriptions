<?php

namespace RedRock\Subscriptions;

// This could be improved by extracting the first five variables to a CookieTest class, which can evaluate itself and has a method like exitEarlyAfterEvaluating.

class CookieTestService extends Service {
    private $returnURI;
    private $forWhom;
    private $silentIfPass;
    
    private $cookieToTest;
    private $expectedCookieValue;
    
    private $defaultTestCookieName  = "test-cookie";
    private $defaultTestCookieValue = "test-cookie-value";
    
    private $thisPluginsName;
    
    public function __construct() {
        $thisPluginsName = Plugin::getDefinitions()->getPluginName();
    }
    
    public function emplaceCallbacks() {
        add_action(
            "plugins_loaded",
            array(
                $this,
                "maybeRunCookieTest"
            )
        );
    }
    
    public function exitEarlyToExecuteDiscreetCookieTest() {
        $returnURI
            = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $encodedReturnURI = urlencode($returnURI);
        
        $expireAtEndOfSession                   = 0;
        $allowAlllPathsToAccessTheCookie        = "/";
        $allowAlllSubdomainsToAccessTheCookie   = "$_SERVER[HTTP_HOST]";
        $transmitTheCookieSecurely              = true;
        $makeTheCookieAccessibleOnlyViaHTTP     = true;
        $letOnlyThisSiteAccessTheCookie         = ["samesite" => "Strict"];
        
        $replaceAnyPreviouslySetLocationHeader  = true;
        $HTTPCodeForSeeOtherRedirect            = 303;
        
        setcookie(
            $defaultTestCookieName,
            $defaultTestCookieValue,
            $expireAtEndOfSession,
            $allowAlllPathsToAccessTheCookie,
            $allowAlllSubdomainsToAccessTheCookie,
            $transmitTheCookieSecurely,
            $makeTheCookieAccessibleOnlyViaHTTP,
            $letOnlyThisSiteAccessTheCookie
        );
        
        header("Location: "
            . "/cookie-check"
            . "?for=$thisPluginsName"
            . "&cookie-name=$defaultTestCookieName"
            . "&expected-value=true"
            . "&silent-if-pass=true"
            . "&return-address=$encodedReturnURI",
            $replaceAnyPreviouslySetLocationHeader,
            $HTTPCodeForSeeOtherRedirect
        );
        
        exit();
    }
    
    public function cookieTestFailed() {
        $cookieTestFailedOutLoud =
            isset($_GET["cookie-test-passed"])
                && (
                    $_GET["cookie-test-passed"] === "false"
                    || $_GET["cookie-test-passed"] === "0"
                );
        
        return $cookieTestFailedOutLoud;
    }

    private function maybeRunCookieTest() {
        $uriWithoutQuery    = strtok($_SERVER["REQUEST_URI"], "?");
        $forWhom            = $_GET["for"];
        
        if (
            $uriWithoutQuery === "/cookie-test"
            && $forWhom === $thisPluginsName
        ) {
            runCookieTest();
        }
    }
    
    private function setUpTest() {
        $cookieToTest   = $_GET["cookie-name"];
        $returnURI      = $_GET["return-address"];
        
        $expectedCookieValue = 
            isset($_GET["cookie-value"])
                ? $_GET["cookie-value"]
                : null;
        
        $silentIfPass =
            isset($_GET["silent-if-pass"])
            && strtolower($_GET["silent-if-pass"]) !== "false"
            && $_GET["silent-if-pass"] !== "0";
    }
    
    private function runCookieTest() {
        setUpTest();
        
        if (!isset($_COOKIE[$cookieToTest])) {
            returnWithAdditionalQueryString(
                "?cookie-test-passed=false"
                . "cookie-absent=true"
                . "&cookie-name=" . $cookieToTest
            );
        }
        else if (
            $expectedCookieValue !== null
            && $_COOKIE[$cookieToTest] !== $expectedCookieValue
        ) {
            returnWithAdditionalQueryString(
                "?cookie-test-passed=false"
                . "cookie-contains-incorrect-value=true"
                . "&cookie-name=" . $cookieToTest
                . "&expected-value=" . $expectedCookieValue
                . "&actual-value=" . $_COOKIE[$cookieToTest]
            );
        }
        else if ($silentIfPass) {
            header("Location: " . urlencode($returnURI));
            exit();
        }
        else {
            returnWithAdditionalQueryString(
                "?cookie-test-passed=true"
                . "&cookie-name=" . $cookieToTest
                . "&cookie-value=" . $expectedCookieValue
            );
        }
    }
    
    private function returnWithAdditionalQueryString($queryString) {
        $returnURIHasQueryString = strpos($returnURI, "?") !== false;
        
        if ($returnURIHasQueryString) {
            header("Location: " . $returnURI . "&" . ltrim($queryString, "?"));
        }
        else {
            header("Location: " . $returnURI . $queryString);
        }
        
        exit();
    }
}
