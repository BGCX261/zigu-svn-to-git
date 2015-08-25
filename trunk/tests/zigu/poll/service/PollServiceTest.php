<?php
require_once 'zigu/poll/PollBaseTestCase.php';
class PollServiceTest extends PollBaseTestCase {
	
	/**
	 * 投票SERVICE测试
	 * @author liuhui 2008-12-17
	 */
	
	/**
	 * 首先组装投票数据，然后再比较新增与组装数据的值，逐步比较
	 *
	 */
	public function testAddPoll() {
		$row = $this->createPollData();
		$poll = $this->getPollService()->addPoll($row);
		$this->assertNotNull($poll);
		$this->assertEquals($row['pollId'],$poll->pollId);
		$this->assertEquals($row['pollTitle'],$poll->pollTitle);
		
		$this->assertNotNull($poll->questions);
		foreach($poll->questions as $key=>$question){
			$this->assertNotNull($question->items);
			$this->assertEquals($row['questions'][$key]['title'],$question->title);
			$this->assertEquals($row['questions'][$key]['questionType'],$question->questionType);
			foreach($question->items as $iKey=>$item){
				$this->assertEquals($row['questions'][$key]['items'][$iKey]['title'],$item->title);
				$this->assertEquals($row['questions'][$key]['items'][$iKey]['questionType'],$item->questionType);				
			}
		}
		$newRow = array();
		$poll = $this->getPollService()->addPoll($newRow);
		$this->assertFalse($poll,'投票数据为空，应该出错，不能新增投票');
		
		$row = $this->createPollData();
		unset($row['questions']);
		$poll = $this->getPollService()->addPoll($row);
		$this->assertFalse($poll,'投票问题数据为空，应该出错，不能新增投票');
	}
	
	public function testGetPoll(){
		$row = $this->createPollData();
		$found = $this->getPollService()->getPoll($row['pollId']);
		$this->assertNull($found);
		
		$this->getPollService()->addPoll($row);
		$found = $this->getPollService()->getPoll($row['pollId']);
		$this->assertNotNull($found);
		$this->assertEquals($row['pollId'],$found->pollId);
		$this->assertEquals($row['pollTitle'],$found->pollTitle);
		
		$this->assertNotNull($found->questions);
		foreach($found->questions as $question){
			$this->assertNotNull($question->items);
			$this->assertEquals($row['questions'][0]['title'],$question->title);
			$this->assertEquals($row['questions'][0]['questionType'],$question->questionType);
			foreach($question->items as $item){
				$this->assertEquals($row['questions'][0]['items'][0]['title'],$item->title);
				$this->assertEquals($row['questions'][0]['items'][0]['questionType'],$item->questionType);				
			}
		}
		
		$found = $this->getPollService()->getPoll(NULL);
		$this->assertNull($found);
	}
	
	public function testDeletePoll(){
		$this->truncateTable();
		$row = $this->createPollData();
		$this->getPollService()->deletePoll($row['pollId']);
		$found = $this->getPollService()->getPoll($row['pollId']);
		$this->assertNull($found);
		
		$this->getPollService()->addPoll($row);
		$found = $this->getPollService()->getPoll($row['pollId']);
		$this->assertNotNull($found);
		
		$delete = $this->getPollService()->deletePoll($row['pollId']);
		$this->assertTrue($delete,'存在数据，应该删除正确');
		$found = $this->getPollService()->getPoll($row['pollId']);
		$this->assertNull($found);
		
		$delete = $this->getPollService()->deletePoll(NULL);
		$this->assertFalse($delete,'投票ID为空，应该错误');
	}
	
//	public function testAttendPoll(){
//		$data = $this->createAttendData();
//		$pollId = '2008';
//		$saved = $this->getPollService()->attendPoll($data,$pollId);
//		$this->assertNotNull($saved);
//		$this->assertEquals($saved[1][1]->questionId,1);//单选
//		$this->assertEquals($saved[2][3][12]->questionId,3);//多选
//		$this->assertEquals($saved[2][3][12]->itemId,12);//多选
//		$this->assertEquals($saved[4][5]->questionId,5);//文本
//		
//		$saved = $this->getPollService()->attendPoll(array(),$pollId);
//		$this->assertNull($saved);
//		
//		$data = $this->createAttendData();
//		$saved = $this->getPollService()->attendPoll($data,null);
//		$this->assertNull($saved);
//	}
	
	public function testUpdatePoll(){
		//questionId为空，应该为新增一条
//		$fields = $row = $this->createPollData();
//		$saved = $this->getPollService()->addPoll($row);
//		$this->assertNotNull($saved);
//		//组装数据，组装一个新增数据
//		$pollId = $fields['pollId'];
//		$fields['pollTitle'] = 'this is a poll';
//		$fields['questions'][0]['title'] = 'this is a Question';
//		$fields['questions'][0]['items'][0]['title'] = 'this is a items';
//		$update = $this->getPollService()->updatePoll($fields,$pollId);
//		$this->assertNotNull($update);
//		$poll = $this->getPollService()->getPoll($pollId);
//		$this->assertEquals($poll->pollTitle,$fields['pollTitle']);	
//		$this->assertEquals($poll->pollId,$pollId);
//		$questions = $poll->questions;
//		$this->assertEquals($fields['questions'][0]['title'],$questions[0]->title);
//		$this->assertEquals($fields['questions'][0]['limitType'],$questions[0]->limitType);
//		$items = $questions[0]->items;
//		$this->assertEquals($fields['questions'][0]['items'][0]['title'],$items[0]->title);
//		$this->assertEquals($fields['questions'][0]['items'][0]['limitType'],$items[0]->limitType);				
		
		//questionId不存在,删除原有数据，再更新数据
		$fields = $row = $this->createPollData();
		$saved = $this->getPollService()->addPoll($row);
		$this->assertNotNull($saved);
		//组装数据，组装一个更新数据
		$pollId = $saved->pollId;
		$questionId = $itemId = 100;
		$fields['pollTitle'] = 'this is a poll';
		$fields['questions'][$questionId] = $fields['questions'][0];
		$fields['questions'][$questionId]['title'] = 'this is a Question';
		$fields['questions'][$questionId]['questionId'] = $questionId;
		$fields['questions'][$questionId]['items'][$itemId] = $fields['questions'][0]['items'][0];
		$fields['questions'][$questionId]['items'][$itemId]['title'] = 'this is a items';
		$fields['questions'][$questionId]['items'][$itemId]['itemId'] = $itemId;
		unset($fields['questions'][$questionId]['items'][0]);
		unset($fields['questions'][0]);
		$update = $this->getPollService()->updatePoll($fields,$pollId);
		$this->assertNotNull($update);
		$poll = $this->getPollService()->getPoll($pollId);	
		$this->assertEquals($poll->pollTitle,$fields['pollTitle']);	
		$this->assertEquals($poll->pollId,$pollId);
		$questions = $poll->questions;
		$this->assertEquals($fields['questions'][$questionId]['title'],$questions[0]->title);
		$this->assertEquals($fields['questions'][$questionId]['limitType'],$questions[0]->limitType);
		$items = $questions[0]->items;
		$this->assertEquals($fields['questions'][$questionId]['items'][$itemId]['title'],$items[0]->title);
		$this->assertEquals($fields['questions'][$questionId]['items'][$itemId]['limitType'],$items[0]->limitType);	
		
		//questionId存在，直接更新数据
		$fields = $row = $this->createPollData();
		$saved = $this->getPollService()->addPoll($row);
		$this->assertNotNull($saved);
		//组装数据，组装一个更新数据
		$pollId = $saved->pollId;
		$questionId = $saved->questions[0]->questionId;
		$itemId = $saved->questions[0]->items[0]->itemId;
		$fields['pollTitle'] = 'this is a poll';
		$fields['questions'][$questionId] = $fields['questions'][0];
		$fields['questions'][$questionId]['title'] = 'this is a Question';
		$fields['questions'][$questionId]['questionId'] = $questionId;
		$fields['questions'][$questionId]['items'][$itemId] = $fields['questions'][0]['items'][0];
		$fields['questions'][$questionId]['items'][$itemId]['title'] = 'this is a items';
		$fields['questions'][$questionId]['items'][$itemId]['itemId'] = $itemId;
		unset($fields['questions'][$questionId]['items'][0]);
		unset($fields['questions'][0]);
		$update = $this->getPollService()->updatePoll($fields,$pollId);
		$this->assertNotNull($update);
		$poll = $this->getPollService()->getPoll($pollId);	
		$this->assertEquals($poll->pollTitle,$fields['pollTitle']);	
		$this->assertEquals($poll->pollId,$pollId);
		$questions = $poll->questions;
		$this->assertEquals($fields['questions'][$questionId]['title'],$questions[0]->title);
		$this->assertEquals($fields['questions'][$questionId]['limitType'],$questions[0]->limitType);
		$items = $questions[0]->items;
		$this->assertEquals($fields['questions'][$questionId]['items'][$itemId]['title'],$items[0]->title);
		$this->assertEquals($fields['questions'][$questionId]['items'][$itemId]['limitType'],$items[0]->limitType);	
	}
	
	private function createAttendData(){
		$this->truncateTable();
		$data[1] = array('1'=>10,'2'=>11);//单选 key = questionId,value=itemId
		$data[2] = array('3'=>array(12,13),'4'=>array(14,15));//多选 key = questionId,value=itemIds
		$data[4] = array('5_16'=>'this is my answer','6_17'=>'this is my other answer');//文本区域  key = questionId_itmeId,value=answer
		return $data;
	}
	
	private function createPollData(){
		$this->truncateTable();
		$poll = $this->getPollDataGenerator()->getRow();
		$question = $this->getQuestionDataGenerator()->getRow();
		$item = $this->getItemDataGenerator()->getRow();
		unset($question['pollId']);
		unset($item['pollId']);
		unset($item['questionId']);
		$question['items'][] = $item;
		$poll['questions'][] = $question;
		return $poll;
	}
	
	private function truncateTable(){
		$this->truncatePollTable();
		$this->truncateQuestionTable();
		$this->truncateItemTable();
		$this->truncateAnswerTable();
		$this->truncateResultTable();
	}
	
	private function getPollService(){
		require_once 'zigu/poll/service/PollServiceFactory.php';
		return PollServiceFactory::getInstance()->createPollService();
	}
}