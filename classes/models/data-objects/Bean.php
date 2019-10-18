<?php

namespace RedRock\Subscriptions;

abstract class Bean {
    public static function buildFromArray($array) {
        $newBean = new Bean;
        
        foreach (get_object_vars($newBean) as $propertyName) {
            $newBean[$propertyName] = $array[$propertyName];
        }
    }
}
