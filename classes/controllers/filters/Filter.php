<?php

namespace RedRock\Subscriptions;

interface Filter {
    public function getOriginal();
    public function getFiltered();
}
