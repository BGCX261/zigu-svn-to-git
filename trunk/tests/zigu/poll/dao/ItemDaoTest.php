<?php

require_once 'zigu/poll/PollBaseTestCase.php';
require_once 'zigu/poll/dao/PollDaoFactory.php';

class ItemDaoTest extends PollBaseTestCase {

    public function testAddItem() {
    	$this->truncateItemTable();
		$row = $this->getItemDataGenerator()->getRow();
	    $saved = $this->getItemDao()->addItem($row);
	    $this->assertNotNull($saved);
	    $this->assertEquals($row['itemId'], $saved->itemId);
	    $this->assertEquals($row['title'], $saved->title);
	    
		$this->truncateItemTable();
        $rows = $this->getItemDataGenerator()->getAll();
        $count = 0;
        foreach ($rows as $row) {
	    	$saved = $this->getItemDao()->addItem($row);
	    	$this->assertNotNull($saved);
	    	$this->assertEquals($row['itemId'], $saved->itemId);
	    	$this->assertEquals($row['title'], $saved->title);
	    	if($saved) $count++;
        }
        $this->assertEquals($count,count($rows));
    }

    public function testFindItem() {
    	$this->truncateItemTable();
		$row = $this->getItemDataGenerator()->getRow();
	    $found = $this->getItemDao()->findItem($row['itemId']);
	    $this->assertNull($found);
	    
	    $this->getItemDao()->addItem($row);
	    $found = $this->getItemDao()->findItem($row['itemId']);
	    $this->assertObjectHasAttribute('itemId', $found);
	    $this->assertEquals($row['itemId'], $found->itemId);
	    $this->assertEquals($row['title'], $found->title);
	    
	    $this->fillItemTable();
	    $found = $this->getItemDao()->findItem($row['itemId']);
	    $this->assertObjectHasAttribute('pollId', $found);
	    $this->assertEquals($row['itemId'], $found->itemId);
	    $this->assertEquals($row['title'], $found->title);
    }

    public function testFindItemsByPollId() {
		$this->truncateItemTable();
		$rows = $this->getItemDataGenerator()->getAll();
		foreach($rows as $row){
			$pollIds[] = $row['pollId'];		
		}
		$newCount = array_count_values($pollIds);
		
		$pollId = $pollIds[array_rand($pollIds)];
		$found = $this->getItemDao()->findItemsByPollId($pollId);
		$this->assertNull($found);
		
		$this->fillItemTable();
		$found = $this->getItemDao()->findItemsByPollId($pollId);
		$this->assertNotNull($found);
		$this->assertEquals(count($found),$newCount[$pollId]);
    }

    public function testFindItemsByQuestionId() {
		$this->truncateItemTable();
		$rows = $this->getItemDataGenerator()->getAll();
		foreach($rows as $row){
			$questionIds[] = $row['questionId'];		
		}
		$newCount = array_count_values($questionIds);
		
		$questionId = $questionIds[array_rand($questionIds)];
		$found = $this->getItemDao()->findItemsByQuestionId($questionId);
		$this->assertNull($found);
		
		$this->fillItemTable();
		$found = $this->getItemDao()->findItemsByQuestionId($questionId);
		$this->assertNotNull($found);
		$this->assertEquals(count($found),$newCount[$questionId]);
    }

    public function testUpdateItem() {
    	$this->truncateItemTable();
		$row = $this->getItemDataGenerator()->getRow();
	    $updateFields['title'] = 'New Item title ' . time();
	    $updated = $this->getItemDao()->updateItem($updateFields, $row['itemId']);
	    $this->assertNull($updated);
	    
	    $this->getItemDao()->addItem($row);
	    $updated = $this->getItemDao()->updateItem($updateFields, $row['itemId']);
	    $this->assertNotNull($updated);
	    $this->assertEquals($updateFields['title'], $updated->title);
	    
	    $this->fillItemTable();
	    $updated = $this->getItemDao()->updateItem($updateFields, $row['itemId']);
	    $this->assertNotNull($updated);
	    $this->assertEquals($updateFields['title'], $updated->title);
    }

    public function testDeleteItem() {
    	$this->truncateItemTable();
		$row = $this->getItemDataGenerator()->getRow();
	    $deletedRowCount = $this->getItemDao()->deleteItem($row['itemId']);
	    $this->assertEquals(0, $deletedRowCount);
	    
	    $this->getItemDao()->addItem($row);
	    $deletedRowCount = $this->getItemDao()->deleteItem($row['itemId']);
	    $this->assertEquals(1, $deletedRowCount);
	    $found = $this->getItemDao()->findItem($row['itemId']);
	    $this->assertNull($found);
	    
	    $this->fillItemTable();
	    $deletedRowCount = $this->getItemDao()->deleteItem($row['itemId']);
	    $this->assertEquals(1, $deletedRowCount);
	    $found = $this->getItemDao()->findItem($row['itemId']);
	    $this->assertNull($found);
    }

    public function testDeleteItems() {
		$this->truncateItemTable();
		$row = $this->getItemDataGenerator()->getRow();
	    $deletedRowCount = $this->getItemDao()->deleteItems(array($row['itemId']));
	    $this->assertEquals(0, $deletedRowCount);
	    
	    $this->getItemDao()->addItem($row);
	    $deletedRowCount = $this->getItemDao()->deleteItems(array($row['itemId']));
	    $this->assertEquals(1, $deletedRowCount);
	    $found = $this->getItemDao()->findItem($row['itemId']);
	    $this->assertNull($found);
	    
	    $rows = $this->fillItemTable();
	    foreach($rows as $row){
	    	$items[] = $row['itemId'];
	    }
	    $deletedRowCount = $this->getItemDao()->deleteItems($items);
	    $this->assertEquals(count($rows), $deletedRowCount);
    }

    public function testDeleteItemsByPollId() {
		$this->truncateItemTable();
		$rows = $this->getItemDataGenerator()->getAll();
		foreach($rows as $row){
			$pollIds[] = $row['pollId'];		
		}
		$newCount = array_count_values($pollIds);
		$pollId = $pollIds[array_rand($pollIds)];
		$delete = $this->getItemDao()->deleteItemsByPollId($pollId);
		$this->assertEquals(0,$delete);
		
		$this->fillItemTable();
		$delete = $this->getItemDao()->deleteItemsByPollId($pollId);
		$this->assertNotNull($delete);
		$this->assertEquals($delete,$newCount[$pollId]);
    }
}