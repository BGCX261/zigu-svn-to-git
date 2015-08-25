<?php

require_once 'zigu/poll/PollBaseTestCase.php';
require_once 'zigu/poll/dao/PollDaoFactory.php';

class AnswerDaoTest extends PollBaseTestCase {

    public function testAddAnswer() {
    	$this->truncateAnswerTable();
		$row = $this->getAnswerDataGenerator()->getRow();
	    $saved = $this->getAnswerDao()->addAnswer($row);
	    $this->assertNotNull($saved);
	    $this->assertEquals($row['answerId'], $saved->answerId);
	    $this->assertEquals($row['answer'], $saved->answer);
	    
		$this->truncateAnswerTable();
        $rows = $this->getAnswerDataGenerator()->getAll();
        $count = 0;
        foreach ($rows as $row) {
	    	$saved = $this->getAnswerDao()->addAnswer($row);
	    	$this->assertNotNull($saved);
	    	$this->assertEquals($row['answerId'], $saved->answerId);
	    	$this->assertEquals($row['answer'], $saved->answer);
	    	if($saved) $count++;
        }
        $this->assertEquals($count,count($rows));
    }

    public function testFindAnswer() {
		$this->truncateAnswerTable();
		$row = $this->getAnswerDataGenerator()->getRow();
	    $found = $this->getAnswerDao()->findAnswer($row['answerId']);
	    $this->assertNull($found);
	    
	    $this->getAnswerDao()->addAnswer($row);
	    $found = $this->getAnswerDao()->findAnswer($row['answerId']);
	    $this->assertObjectHasAttribute('answerId', $found);
	    $this->assertEquals($row['answerId'], $found->answerId);
	    $this->assertEquals($row['answer'], $found->answer);
	    
	    $this->fillAnswerTable();
	    $found = $this->getAnswerDao()->findAnswer($row['answerId']);
	    $this->assertObjectHasAttribute('answerId', $found);
	    $this->assertEquals($row['answerId'], $found->answerId);
	    $this->assertEquals($row['answer'], $found->answer);
    }

    public function testFindAnswersByPollId() {
		$this->truncateAnswerTable();
		$rows = $this->getAnswerDataGenerator()->getAll();
		foreach($rows as $row){
			$pollIds[] = $row['pollId'];		
		}
		$newCount = array_count_values($pollIds);
		
		$pollId = $pollIds[array_rand($pollIds)];
		$found = $this->getAnswerDao()->findAnswersByPollId($pollId);
		$this->assertNull($found);
		
		$this->fillAnswerTable();
		$found = $this->getAnswerDao()->findAnswersByPollId($pollId);
		$this->assertNotNull($found);
		$this->assertEquals(count($found),$newCount[$pollId]);
    }

    public function testFindAnswersByItemId() {
		$this->truncateAnswerTable();
		$rows = $this->getAnswerDataGenerator()->getAll();
		foreach($rows as $row){
			$itemIds[] = $row['itemId'];		
		}
		$newCount = array_count_values($itemIds);
		
		$itemId = $itemIds[array_rand($itemIds)];
		$found = $this->getAnswerDao()->findAnswersByItemId($itemId);
		$this->assertNull($found);
		
		$this->fillAnswerTable();
		$found = $this->getAnswerDao()->findAnswersByItemId($itemId);
		$this->assertNotNull($found);
		$this->assertEquals(count($found),$newCount[$itemId]);
    }

    public function testUpdateAnswer() {
		$this->truncateAnswerTable();
    	$row = $this->getAnswerDataGenerator()->getRow();
	    $updateFields['answer'] = 'New Answer ' . time();
	    $updated = $this->getAnswerDao()->updateAnswer($updateFields, $row['answerId']);
	    $this->assertNull($updated);
	    
	    $this->getAnswerDao()->addAnswer($row);
	    $updated = $this->getAnswerDao()->updateAnswer($updateFields, $row['answerId']);
	    $this->assertNotNull($updated);
	    $this->assertEquals($updateFields['answer'], $updated->answer);
	    
	    $this->fillAnswerTable();
	    $updated = $this->getAnswerDao()->updateAnswer($updateFields, $row['answerId']);
	    $this->assertNotNull($updated);
	    $this->assertEquals($updateFields['answer'], $updated->answer);
    }

    public function testDeleteAnswer() {
		$this->truncateAnswerTable();
		$row = $this->getAnswerDataGenerator()->getRow();
	    $deletedRowCount = $this->getAnswerDao()->deleteAnswer($row['itemId']);
	    $this->assertEquals(0, $deletedRowCount);
	    
	    $this->getAnswerDao()->addAnswer($row);
	    $deletedRowCount = $this->getAnswerDao()->deleteAnswer($row['itemId']);
	    $this->assertEquals(1, $deletedRowCount);
	    $found = $this->getAnswerDao()->findAnswer($row['itemId']);
	    $this->assertNull($found);
	    
	    $this->fillAnswerTable();
	    $deletedRowCount = $this->getAnswerDao()->deleteAnswer($row['itemId']);
	    $this->assertEquals(1, $deletedRowCount);
	    $found = $this->getAnswerDao()->findAnswer($row['itemId']);
	    $this->assertNull($found);
    }

    public function testDeleteAnswersByPollId() {
		$this->truncateAnswerTable();
		$rows = $this->getAnswerDataGenerator()->getAll();
		foreach($rows as $row){
			$pollIds[] = $row['pollId'];		
		}
		$newCount = array_count_values($pollIds);
		
		$pollId = $pollIds[array_rand($pollIds)];
		$found = $this->getAnswerDao()->deleteAnswersByPollId($pollId);
		$this->assertEquals(0,$found);
		
		$this->fillAnswerTable();
		$found = $this->getAnswerDao()->deleteAnswersByPollId($pollId);
		$this->assertNotNull($found);
		$this->assertEquals($found,$newCount[$pollId]);
    }
    

}
	
