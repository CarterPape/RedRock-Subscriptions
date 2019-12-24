<?php

namespace RedRock\Subscriptions;

class Measurement extends Bean {
    public $magnitude;
    public $unit;
    public $pluralizedUnit;
    
    public function __construct(
        $magnitude,
        string $unit,
        string $pluralizedUnit = null
    ) {
        $this->magnitude = $magnitude;
        $this->unit = $unit;
        if ($pluralizedUnit == null) {
            $pluralizedUnit = $unit . "s";
        }
        else {
            $this->pluralizedUnit = $pluralizedUnit;
        }
    }
    
    function __toString() {
        return strval($magnitude) . " " . maybePluralizedUnit();
    }
    
    private function maybePluralizedUnit() {
        if ($magnitude === 1) {
            return $unit;
        }
        else {
            return $pluralizedUnit;
        }
    }
}
