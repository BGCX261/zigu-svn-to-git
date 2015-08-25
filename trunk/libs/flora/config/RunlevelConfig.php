<?php

require_once 'flora/config/Environment.php';

class RunlevelConfig {

    public static function load($dir, $name) {
        $filepath = $dir . DIRECTORY_SEPARATOR . $name . '.' . Environment::$runLevel . '.php';
        return include($filepath); 
    }
}