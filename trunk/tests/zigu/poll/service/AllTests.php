<?php

require_once 'PHPUnit/Util/Filter.php';
require_once 'PHPUnit/Framework/TestSuite.php';

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'PollServiceTest.php';

class Service_AllTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Zigu Service');
        $suite->addTestSuite('PollServiceTest');
        return $suite;
    }
}
