<?php
require_once 'PHPUnit/Framework/TestCase.php';

abstract class BaseTestCase extends PHPUnit_Framework_TestCase {
    public function __construct() {
        parent::__construct();
//        Environment::setRunLevel(Environment::TEST);
    }
}