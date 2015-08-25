<?php

require_once 'zigu/ZiguBaseTestCase.php';
require_once 'zigu/poll/dao/PollConnectionFactory.php';

class PollConnectionFactoryTest extends ZiguBaseTestCase  {
    public function testGetConnection() {
        $factory = PollConnectionFactory::getInstance();
        $conn1 = $factory->getConnection();
        $this->assertType('PDO', $conn1);
        $conn2 = $factory->getConnection();
        $this->assertType('PDO', $conn2);
        $this->assertSame($conn1, $conn2);
        
    }
    
    public function testGetInstance() {
        $factory = PollConnectionFactory::getInstance();
        $this->assertType('PollConnectionFactory',$factory);
        $conn =$factory->getConnection();
        $this->assertType('PDO', $conn);
    }
}