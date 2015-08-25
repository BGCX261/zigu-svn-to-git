<?php

require_once 'BaseTestCase.php';
require_once 'flora/config/Environment.php';

abstract class ZiguBaseTestCase extends BaseTestCase {
    
    public function __construct() {
        Environment::setRunLevel(Environment::TEST);
    }
}