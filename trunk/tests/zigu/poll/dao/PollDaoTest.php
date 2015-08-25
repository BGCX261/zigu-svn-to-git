<?php
require_once 'zigu/poll/PollBaseTestCase.php';
require_once 'zigu/poll/dao/PollDaoFactory.php';

class PollDaoTest extends PollBaseTestCase {
	
	public function testAddPoll() {
		$row = $this->getPollDataGenerator ()->getRow ();
		
		$saved = $this->getPollDao()->addPoll ( $row );
		$this->assertNotNull ( $saved );
		$this->assertEquals ( $row ['pollId'], $saved->pollId );
		$this->assertEquals ( $row ['pollTitle'], $saved->pollTitle );
		
		$this->truncatePollTable ();
		$rows = $this->getPollDataGenerator ()->getAll ();
		$count = 0;
		foreach ( $rows as $row ) {
			$saved = $this->getPollDao ()->addPoll ( $row );
			$this->assertNotNull ( $saved );
			$this->assertEquals ( $row ['pollId'], $saved->pollId );
			$this->assertEquals ( $row ['pollTitle'], $saved->pollTitle );
			if ($saved)
				$count ++;
		}
		$this->assertEquals ( $count, count ( $rows ) );
	}
	
	public function testFindPoll() {
		$row = $this->getPollDataGenerator ()->getRow ();
		$found = $this->getPollDao ()->findPoll ( $row ['pollId'] );
		$this->assertNull ( $found );
		
		$this->getPollDao ()->addPoll ( $row );
		$found = $this->getPollDao ()->findPoll ( $row ['pollId'] );
		$this->assertObjectHasAttribute ( 'pollId', $found );
		$this->assertEquals ( $row ['pollId'], $found->pollId );
		$this->assertEquals ( $row ['pollTitle'], $found->pollTitle );
		
		$this->fillPollTable ();
		$found = $this->getPollDao ()->findPoll ( $row ['pollId'] );
		$this->assertObjectHasAttribute ( 'pollId', $found );
		$this->assertEquals ( $row ['pollId'], $found->pollId );
		$this->assertEquals ( $row ['pollTitle'], $found->pollTitle );
	}
	
	public function testUpdatePoll() {
		$row = $this->getPollDataGenerator ()->getRow ();
		$updateFields ['pollTitle'] = 'New Poll title ' . time ();
		$updated = $this->getPollDao ()->updatePoll ( $updateFields, $row ['pollId'] );
		$this->assertNull ( $updated );
		
		$this->getPollDao ()->addPoll ( $row );
		$updated = $this->getPollDao ()->updatePoll ( $updateFields, $row ['pollId'] );
		$this->assertNotNull ( $updated );
		$this->assertEquals ( $updateFields ['pollTitle'], $updated->pollTitle );
		
		$this->fillPollTable ();
		$updated = $this->getPollDao ()->updatePoll ( $updateFields, $row ['pollId'] );
		$this->assertNotNull ( $updated );
		$this->assertEquals ( $updateFields ['pollTitle'], $updated->pollTitle );
	}
	
	public function testDeletePoll() {
		$row = $this->getPollDataGenerator ()->getRow ();
		$deletedRowCount = $this->getPollDao ()->deletePoll ( $row ['pollId'] );
		$this->assertEquals ( 0, $deletedRowCount );
		
		$this->getPollDao ()->addPoll ( $row );
		$deletedRowCount = $this->getPollDao ()->deletePoll ( $row ['pollId'] );
		$this->assertEquals ( 1, $deletedRowCount );
		$found = $this->getPollDao ()->findPoll ( $row ['pollId'] );
		$this->assertNull ( $found );
		
		$this->fillPollTable ();
		$deletedRowCount = $this->getPollDao ()->deletePoll ( $row ['pollId'] );
		$this->assertEquals ( 1, $deletedRowCount );
		$found = $this->getPollDao ()->findPoll ( $row ['pollId'] );
		$this->assertNull ( $found );
	}
	
	public function testDeletePolls() {
		$pollIds = $this->getPollDataGenerator ()->getColumnPartial ( 'pollId' );
		$deletedRowCount = $this->getPollDao ()->deletePolls ( $pollIds );
		$this->assertEquals ( 0, $deletedRowCount );
		
		$row = $this->getPollDataGenerator ()->getRowByFieldEqual ( 'pollId', $pollIds [0] );
		$this->getPollDao ()->addPoll ( $row );
		$deletedRowCount = $this->getPollDao ()->deletePolls ( $pollIds );
		$this->assertEquals ( 1, $deletedRowCount );
		
		$this->fillPollTable ();
		$deletedRowCount = $this->getPollDao ()->deletePolls ( $pollIds );
		$this->assertEquals ( count ( $pollIds ), $deletedRowCount );
	}
	
	public function testFindPolls(){
		$this->truncatePollTable();
		$found = $this->getPollDao()->findPolls();
		$this->assertNull($found);
		
		$row = $this->getPollDataGenerator()->getRow();
		$this->getPollDao()->addPoll($row);
		$found = $this->getPollDao()->findPolls(); 
		$this->assertNotNull($found);
		$this->assertEquals($row['pollTitle'],$found[0]->pollTitle);
		$this->assertEquals(1,count($found));
		
		$this->fillPollTable();
		$rows = $this->getPollDataGenerator()->getAll();
		$found = $this->getPollDao()->findPolls(); 
		$this->assertNotNull($found);
		$this->assertEquals(count($rows),count($found));
	}
	
	public function setUp() {
		$this->truncatePollTable ();
	}

}
