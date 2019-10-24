<?php
/*
Plugin Name: RedRock Subscriptions
Description: Sell and manage subscriptions and restrict access to content with WordPress and Memberful.
Author: The Times-Independent
Author URI: http://moabtimes.com/
*/

namespace RedRock\Subscriptions;

require "fundamental/Plugin.php";

$thePlugin = Plugin::spawn(__FILE__);
$thePlugin->run();
