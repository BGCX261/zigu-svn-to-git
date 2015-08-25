<?php

require_once 'PHPUnit/Util/Filter.php';
require_once 'PHPUnit/Framework/TestSuite.php';

PHPUnit_Util_Filter::addFileToFilter(__FILE__);

require_once 'zigu/poll/dao/AllTests.php';
class ZiguAllTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Zigu Core');
        $suite->addTest(PollDaoAllTests::suite());
        return $suite;
    }
}
