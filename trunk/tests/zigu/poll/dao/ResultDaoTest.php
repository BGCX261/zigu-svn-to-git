<?php

require_once 'zigu/poll/PollBaseTestCase.php';
require_once 'zigu/poll/dao/PollDaoFactory.php';

class ResultDaoTest extends PollBaseTestCase {
    public function testAddResult() {
        $this->truncateResultTable();
		$row = $this->getResultDataGenerator()->getRow();
	    $saved = $this->getResultDao()->addResult($row);
	    $this->assertNotNull($saved);
	    $this->assertEquals($row['resultId'], $saved->resultId);
	    $this->assertEquals($row['pollCounts'], $saved->pollCounts);
	    
	    $this->truncateResultTable();
        $rows = $this->getResultDataGenerator()->getAll();
        $count = 0;
        foreach ($rows as $row) {
	   		$saved = $this->getResultDao()->addResult($row);
	    	$this->assertNotNull($saved);
	    	$this->assertEquals($row['resultId'], $saved->resultId);
	    	$this->assertEquals($row['pollCounts'], $saved->pollCounts);
	    	if($saved) $count++;
        }
        $this->assertEquals($count,count($rows));
    }
    
    public function testFindResult(){
    	$this->truncateResultTable();
		$row = $this->getResultDataGenerator()->getRow();
	    $found = $this->getResultDao()->findResult($row['resultId']);
	    $this->assertNull($found);
	    
	    $this->getResultDao()->addResult($row);
	    $found = $this->getResultDao()->findResult($row['resultId']);
	    $this->assertObjectHasAttribute('resultId', $found);
	    $this->assertEquals($row['resultId'], $found->resultId);
	    $this->assertEquals($row['pollCounts'], $found->pollCounts);
	    
	    $this->fillResultTable();
	    $found = $this->getResultDao()->findResult($row['resultId']);
	    $this->assertObjectHasAttribute('resultId', $found);
	    $this->assertEquals($row['resultId'], $found->resultId);
	    $this->assertEquals($row['pollCounts'], $found->pollCounts);
    }
    
    //@todo 不要删除
    public function testFindResultsByItemId(){
//    	$this->truncateResultTable();
//		$rows = $this->getResultDataGenerator()->getAll();
//		foreach($rows as $row){
//			$itemIds[] = $row['itemId'];		
//		}
//		$newCount = array_count_values($itemIds);
//		
//		$itemId = $itemIds[array_rand($itemIds)];
//		$found = $this->getResultDao()->findResultsByItemId($itemId);
//		$this->assertNull($found);
//		
//		$this->fillResultTable();
//		$found = $this->getResultDao()->findResultsByItemId($itemId);
//		$this->assertNotNull($found);
//		$this->assertEquals(count($found),$newCount[$itemId]);
    	$this->truncateResultTable();
		$row = $this->getResultDataGenerator()->getRow();
	    $found = $this->getResultDao()->findResult($row['itemId']);
	    $this->assertNull($found);
	    
	    $this->getResultDao()->addResult($row);
	    $found = $this->getResultDao()->findResult($row['itemId']);
	    $this->assertObjectHasAttribute('itemId', $found);
	    $this->assertEquals($row['resultId'], $found->resultId);
	    $this->assertEquals($row['pollCounts'], $found->pollCounts);
	    
	    $this->fillResultTable();
	    $found = $this->getResultDao()->findResult($row['itemId']);
	    $this->assertObjectHasAttribute('itemId', $found);
	    $this->assertEquals($row['resultId'], $found->resultId);
	    $this->assertEquals($row['pollCounts'], $found->pollCounts);
    }
    
    
    public function testFindResultsByPollId(){
    	$this->truncateResultTable();
		$rows = $this->getResultDataGenerator()->getAll();
		foreach($rows as $row){
			$pollIds[] = $row['pollId'];		
		}
		$newCount = array_count_values($pollIds);
		
		$pollId = $pollIds[array_rand($pollIds)];
		$found = $this->getResultDao()->findResultsByPollId($pollId);
		$this->assertNull($found);
		
		$this->fillResultTable();
		$found = $this->getResultDao()->findResultsByPollId($pollId);
		$this->assertNotNull($found);
		$this->assertEquals(count($found),$newCount[$pollId]);
    }
    
    public function testUpdateResult(){
    	$this->truncateResultTable();
    	$row = $this->getResultDataGenerator()->getRow();
	    $updateFields['pollCounts'] = '100';
	    $updated = $this->getResultDao()->updateResult($updateFields, $row['resultId']);
	    $this->assertNull($updated);
	    
	    $this->getResultDao()->addResult($row);
	    $updated = $this->getResultDao()->updateResult($updateFields, $row['resultId']);
	    $this->assertNotNull($updated);
	    $this->assertEquals($updateFields['pollCounts'], $updated->pollCounts);
	    
	    $this->fillResultTable();
	    $updated = $this->getResultDao()->updateResult($updateFields, $row['resultId']);
	    $this->assertNotNull($updated);
	    $this->assertEquals($updateFields['pollCounts'], $updated->pollCounts);
    }
    
    public function updateResultCount(){
    	$this->truncateResultTable();
    	$update = $this->getResultDao()->updateResultcount(1,NULL);
    	$this->assertEquals(0,$update);
    	
    	$row = $this->getResultDataGenerator()->getRow();
    	$this->getResultDao()->addResult($row);
    	$update = $this->getResultDao()->updateResultcount(1,NULL);
    	$this->assertNotNull($update);
    	$this->assertEquals(1,$update);
    	
    }
    
    public function testDeleteResult(){
    	$this->truncateResultTable();
		$row = $this->getResultDataGenerator()->getRow();
	    $deletedRowCount = $this->getResultDao()->deleteResult($row['resultId']);
	    $this->assertEquals(0, $deletedRowCount);
	    
	    $this->getResultDao()->addResult($row);
	    $deletedRowCount = $this->getResultDao()->deleteResult($row['resultId']);
	    $this->assertEquals(1, $deletedRowCount);
	    $found = $this->getResultDao()->findResult($row['resultId']);
	    $this->assertNull($found);
	    
	    $this->fillResultTable();
	    $deletedRowCount = $this->getResultDao()->deleteResult($row['resultId']);
	    $this->assertEquals(1, $deletedRowCount);
	    $found = $this->getResultDao()->findResult($row['resultId']);
	    $this->assertNull($found);
    }
    
    public function testDeleteResultsByPollId(){
    	$this->truncateResultTable();
		$rows = $this->getResultDataGenerator()->getAll();
		foreach($rows as $row){
			$pollIds[] = $row['pollId'];		
		}
		$newCount = array_count_values($pollIds);
		
		$pollId = $pollIds[array_rand($pollIds)];
		$found = $this->getResultDao()->deleteResultsByPollId($pollId);
		$this->assertEquals(0,$found);
		
		$this->fillResultTable();
		$found = $this->getResultDao()->deleteResultsByPollId($pollId);
		$this->assertNotNull($found);
		$this->assertEquals($found,$newCount[$pollId]);
    }
    

}