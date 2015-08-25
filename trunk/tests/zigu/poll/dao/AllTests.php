<?php

require_once 'PHPUnit/Util/Filter.php';
require_once 'PHPUnit/Framework/TestSuite.php';

require_once 'zigu/poll/dao/AnswerDaoTest.php';
require_once 'zigu/poll/dao/PollConnectionFactoryTest.php';
require_once 'zigu/poll/dao/PollDaoTest.php';
require_once 'zigu/poll/dao/ItemDaoTest.php';
require_once 'zigu/poll/dao/QuestionDaoTest.php';
require_once 'zigu/poll/dao/ResultDaoTest.php';

class PollDaoAllTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Zigu Poll Dao');
        $suite->addTestSuite('AnswerDaoTest');
        $suite->addTestSuite('PollConnectionFactoryTest');
        $suite->addTestSuite('PollDaoTest');
        $suite->addTestSuite('ItemDaoTest');
        $suite->addTestSuite('QuestionDaoTest');
        $suite->addTestSuite('ResultDaoTest');
        return $suite;
    }
}