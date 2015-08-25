<?php

require_once 'flora/FloraBaseTestCase.php';
require_once 'flora/dao/ConnectionFactory.php';

class ConnectionFactoryTest extends FloraBaseTestCase {
	public function testGetConnection() {
		$connFatory = ConnectionFactory::getInstance();
		$config = include dirname(__FILE__) . '/_files/database.cnf.php';
		$connFatory->setConfiguration($config);
		
		$test1Conn1 = $connFatory->getConnction('test1');
		$this->assertType('PDO', $test1Conn1);
		$test1Conn2 = $connFatory->getConnction('test1');
		$this->assertType('PDO', $test1Conn2);
		$this->assertSame($test1Conn1, $test1Conn2);
		
		$test2Conn1 = $connFatory->getConnction('test2');
		$this->assertType('PDO', $test2Conn1);
		$test2Conn2 = $connFatory->getConnction('test2');
		$this->assertType('PDO', $test2Conn2);
		$this->assertSame($test2Conn1, $test2Conn2);
		
		$this->assertNotSame($test1Conn1, $test2Conn1);
	}
}