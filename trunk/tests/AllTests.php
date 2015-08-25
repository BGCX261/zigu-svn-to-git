<?php

error_reporting(E_ALL | E_STRICT);

require_once 'PHPUnit/Util/Filter.php';
require_once 'PHPUnit/Framework/TestSuite.php';

PHPUnit_Util_Filter::addFileToFilter(__FILE__);

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'zigu' . DIRECTORY_SEPARATOR . 'AllTests.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'TestSetup.php';

class AllTests
{
    public static function suite()
    {
//    	TestSetup::reCreateTables();
        $suite = new PHPUnit_Framework_TestSuite('Zigu Poll System');
        $suite->addTest(ZiguAllTests::suite());
        return $suite;
    }
}