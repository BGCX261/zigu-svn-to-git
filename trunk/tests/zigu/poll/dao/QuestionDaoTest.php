<?php
require_once 'zigu/poll/PollBaseTestCase.php';
require_once 'zigu/poll/dao/PollDaoFactory.php';

class QuestionDaoTest extends PollBaseTestCase {

    public function testAddQuestion() {
    	$this->truncateQuestionTable();
		$row = $this->getQuestionDataGenerator()->getRow();
	    $saved = $this->getQuestionDao()->addQuestion($row);
	    $this->assertNotNull($saved);
	    $this->assertEquals($row['questionId'], $saved->questionId);
	    $this->assertEquals($row['title'], $saved->title);
	    
	    $this->truncateQuestionTable();
        $rows = $this->getQuestionDataGenerator()->getAll();
        $count = 0;
        foreach ($rows as $row) {
	   		$saved = $this->getQuestionDao()->addQuestion($row);
	    	$this->assertNotNull($saved);
	    	$this->assertEquals($row['questionId'], $saved->questionId);
	    	$this->assertEquals($row['title'], $saved->title);
	    	if($saved) $count++;
        }
        $this->assertEquals($count,count($rows));
    }

    public function testFindQuestion() {
    	$this->truncateQuestionTable();
		$row = $this->getQuestionDataGenerator()->getRow();
	    $found = $this->getQuestionDao()->findQuestion($row['questionId']);
	    $this->assertNull($found);
	    
	    $this->getQuestionDao()->addQuestion($row);
	    $found = $this->getQuestionDao()->findQuestion($row['questionId']);
	    $this->assertObjectHasAttribute('questionId', $found);
	    $this->assertEquals($row['questionId'], $found->questionId);
	    $this->assertEquals($row['title'], $found->title);
	    
	    $this->fillQuestionTable();
	    $found = $this->getQuestionDao()->findQuestion($row['questionId']);
	    $this->assertObjectHasAttribute('questionId', $found);
	    $this->assertEquals($row['questionId'], $found->questionId);
	    $this->assertEquals($row['title'], $found->title);
    }

    public function testFindQuestionsByPollId() {
    	$this->truncateQuestionTable();
		$rows = $this->getQuestionDataGenerator()->getAll();
		foreach($rows as $row){
			$pollIds[] = $row['pollId'];		
		}
		$newCount = array_count_values($pollIds);
		
		$pollId = $pollIds[array_rand($pollIds)];
		$found = $this->getQuestionDao()->findQuestionsByPollId($pollId);
		$this->assertNull($found);
		
		$this->fillQuestionTable();
		$found = $this->getQuestionDao()->findQuestionsByPollId($pollId);
		$this->assertNotNull($found);
		$this->assertEquals(count($found),$newCount[$pollId]);
		
    }

    public function testUpdateQuestion() {
		$this->truncateQuestionTable();
    	$row = $this->getQuestionDataGenerator()->getRow();
	    $updateFields['title'] = 'New Question title ' . time();
	    $updated = $this->getQuestionDao()->updateQuestion($updateFields, $row['questionId']);
	    $this->assertNull($updated);
	    
	    $this->getQuestionDao()->addQuestion($row);
	    $updated = $this->getQuestionDao()->updateQuestion($updateFields, $row['questionId']);
	    $this->assertNotNull($updated);
	    $this->assertEquals($updateFields['title'], $updated->title);
	    
	    $this->fillQuestionTable();
	    $updated = $this->getQuestionDao()->updateQuestion($updateFields, $row['questionId']);
	    $this->assertNotNull($updated);
	    $this->assertEquals($updateFields['title'], $updated->title);
    }

    public function testDeleteQuestion() {
    	$this->truncateQuestionTable();
		$row = $this->getQuestionDataGenerator()->getRow();
	    $deletedRowCount = $this->getQuestionDao()->deleteQuestion($row['questionId']);
	    $this->assertEquals(0, $deletedRowCount);
	    
	    $this->getQuestionDao()->addQuestion($row);
	    $deletedRowCount = $this->getQuestionDao()->deleteQuestion($row['questionId']);
	    $this->assertEquals(1, $deletedRowCount);
	    $found = $this->getQuestionDao()->findQuestion($row['questionId']);
	    $this->assertNull($found);
	    
	    $this->fillQuestionTable();
	    $deletedRowCount = $this->getQuestionDao()->deleteQuestion($row['questionId']);
	    $this->assertEquals(1, $deletedRowCount);
	    $found = $this->getQuestionDao()->findQuestion($row['questionId']);
	    $this->assertNull($found);
    }

    public function testDeleteQuestionsByPollId() {
		$this->truncateQuestionTable();
		$rows = $this->getQuestionDataGenerator()->getAll();
		foreach($rows as $row){
			$pollIds[] = $row['pollId'];		
		}
		$newCount = array_count_values($pollIds);
		
		$pollId = $pollIds[array_rand($pollIds)];
		$found = $this->getQuestionDao()->deleteQuestionsByPollId($pollId);
		$this->assertEquals(0,$found);
		
		$this->fillQuestionTable();
		$found = $this->getQuestionDao()->deleteQuestionsByPollId($pollId);
		$this->assertNotNull($found);
		$this->assertEquals($found,$newCount[$pollId]);
    }
    

}