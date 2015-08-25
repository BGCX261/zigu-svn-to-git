<?php
require_once 'zigu/poll/service/PollService.php';
require_once 'zigu/base/BaseService.php';
class PollServiceImpl extends BaseService implements PollService {
    
	public function addPoll(array $pollData){
		$poll = $this->insertPoll($pollData);
		if(!$poll || !$pollData['questions'] ) return FALSE;
		foreach($pollData['questions'] as $question){
			$question = array_merge($question,array('pollId'=>$poll->pollId));
			$poll->questions[] = $this->addQuestion($question);
		}
		return $poll;
	}
	
	private function addQuestion(array $questionData){
		$question = $this->insertQuestion($questionData);
		if(!$question || !$questionData['items'] ) return FALSE;
		foreach($questionData['items'] as $item){
			$item = array_merge($item,array('pollId'=>$question->pollId,'questionId'=>$question->questionId,'questionType'=>$question->questionType));
			$question->items[] = $this->insertItem($item);
		} 
		return $question;
	}
	
	private function insertPoll(array $fields){
		$fields = $this->checkPoll($fields);
		if(!$fields) return NULL;
		return $this->getPollDao()->addPoll($fields);
	}
	
	private $pollStatus = array('draft','online','ing','offline');
	
	private function checkPoll(array $data){
		if(!$data) return FALSE;
		$needField = array('pollTitle','limitType','pollStatus');
		if(array_intersect($needField,array_keys($data)) != $needField) return FALSE;
		if(intval($data['pollId'])) $fields['pollId'] = intval($data['pollId']);
		$fields['pollTitle'] = trim($data['pollTitle']);
		$fields['limitType'] = $data['limitType'];
		$fields['pollStatus'] = (in_array($data['pollStatus'],$this->pollStatus)) ? $data['pollStatus'] : 'draft';
		if($data['resultVisiable']) $fields['resultVisiable'] = intval($data['resultVisiable']);
		if($data['freezeTime']) $fields['freezeTime'] = intval($data['freezeTime']);
		$fields['startTime'] = ($data['startTime']) ? $data['startTime'] : time();
		if($data['endTime']) $fields['endTime'] = $data['endTime'];
		if(intval($data['resultDisplayOrder'])) $fields['resultDisplayOrder'] = intval($data['resultDisplayOrder']);
		$fields['initCount'] = ($data['initCount']) ? intval($data['initCount']) : 0;
		if($data['template']) $fields['template'] = $data['template'];
		if($data['customTemplate']) $fields['customTemplate'] = $data['customTemplate'];
		if($data['templateUrl']) $fields['templateUrl'] = $data['templateUrl'];
		$fields['createTime'] = ($data['createTime']) ? $data['createTime'] : time();
		if($data['createUser']) $fields['createUser'] = $data['createUser'];
		$fields['updateTime'] = ($data['updateTime']) ? $data['updateTime'] : time();
		if($data['updateUser']) $fields['updateUser'] = $data['updateUser'];
		return $fields;
	}
	
	private function insertQuestion(array $fields){
		$fields = $this->checkQuestion($fields);
		if(!$fields) return NULL;
		return $this->getQuestionDao()->addQuestion($fields);
	}
	
	private function checkQuestion(array $data){
		if(!$data) return FALSE;
		$needField = array('pollId','title','questionType');
		if(array_intersect($needField,array_keys($data)) != $needField) return FALSE;
		$fields['pollId'] = intval($data['pollId']);
		$fields['title'] = trim($data['title']);
		$fields['questionType'] = intval($data['questionType']);
		if($data['name']) $fields['name'] = $data['name'];
		if($data['maxMultiOptions']) $fields['maxMultiOptions'] = intval($data['maxMultiOptions']);
		if($data['required']) $fields['required'] = intval($data['required']);
		if($data['questionUrl']) $fields['questionUrl'] = $data['questionUrl'];
		if($data['imgUrl']) $fields['imgUrl'] = $data['imgUrl'];
		if($data['textField1']) $fields['textField1'] = $data['textField1'];
		if($data['textField2']) $fields['textField2'] = $data['textField2'];
		if($data['numField1']) $fields['numField1'] = $data['numField1'];
		if($data['numField2']) $fields['numField2'] = $data['numField2'];
		return $fields;
	}
	
	private function insertItem(array $fields){
		$fields = $this->checkItem($fields);
		if(!$fields) return NULL;
		return $this->getItemDao()->addItem($fields);
	}
	
	private function checkItem(array $data){
		if(!$data) return FALSE;
		$needField = array('questionId','pollId','title');
		if(array_intersect($needField,array_keys($data)) != $needField) return FALSE;
		$fields['pollId'] = intval($data['pollId']);
		$fields['questionId'] = intval($data['questionId']);
		$fields['name'] = $data['name'];
		$fields['title'] = trim($data['title']);
		if($data['questionType']) $fields['questionType'] = intval($data['questionType']);
		if($data['initCount']) $fields['initCount'] = intval($data['initCount']);
		if($data['minLength']) $fields['minLength'] = intval($data['minLength']);
		if($data['maxLength']) $fields['maxLength'] = intval($data['maxLength']);
		if($data['fieldType']) $fields['fieldType'] = $data['fieldType'];
		if($data['imgUrl']) $fields['imgUrl'] = $data['imgUrl'];
		if($data['itemUrl']) $fields['itemUrl'] = $data['itemUrl'];
		return $fields;
	}
	
	public function deletePoll($pollId){
		$pollId = $this->checkIntParam($pollId);
		if(!$pollId) return FALSE;
		$this->getPollDao()->deletePoll($pollId);
		$this->getQuestionDao()->deleteQuestionsByPollId($pollId);
		$this->getItemDao()->deleteItemsByPollId($pollId);
		$this->getAnswerDao()->deleteAnswersByPollId($pollId);
		$this->getResultDao()->deleteResultsByPollId($pollId);
		return TRUE;
	}
	
	/****************************获取投票**************************************/
	
	public function getPoll($pollId){
		$poll = $this->getPollByPollId($pollId);
		if(!$poll) return NULL;
		$poll->questions = $this->getQuestions($pollId);
		return $poll;		
	}
	
	private function getQuestions($pollId){
		$questions = $this->getQuestionsByPollId($pollId);
		if(!$questions) return NULL;
		$oQeustion = array();
		foreach($questions as $question){
			$question->items = $this->getItemsByQuestionId($question->questionId);
			$oQeustion[] = $question;
		}
		return $oQeustion;
	}
	
	private function getPollByPollId($pollId){
		$pollId = $this->checkIntParam($pollId);
		if(!$pollId) return FALSE;
		return $this->getPollDao()->findPoll($pollId);
	}
	
	private function getQuestionsByPollId($pollId){
		$this->checkIntParam($pollId);
		if(!$pollId) return NULL;
		return $this->getQuestionDao()->findQuestionsByPollId($pollId);
	}
	
	private function getItemsByQuestionId($questionId){
		$this->checkIntParam($questionId);
		if(!$questionId) return NULL;
		return $this->getItemDao()->findItemsByQuestionId($questionId);
	}
	
	/**
	 * 更新投票process
	 * 1，更新poll部分，成功与否不影响其它更新
	 * 2，更新question部分，如果存在的questionId没有传进，则删除，如果有新增的选项则增加，否则更新
	 * 3，更新item部分，如果存在的itmeId没有传进，则删除，如果有新增的选项则增加，否则更新
	 */
	public function updatePoll($pollData,$pollId){
		if(!$pollData || !$pollData['questions'] || !$pollId) return NULL;
		$poll = $this->updatePollByPollId($pollData,$pollId);//是否更新成功不影响其它更新
		$currentQuestionIds = $this->getCurrentQuestionIds($pollId);
		
		$questionIds = array();
		foreach($pollData['questions'] as $questionId => $question){
			if($questionId) $questionIds[] = $questionId;
			$this->updateQuestion($question,$questionId,$pollId);
		}
		$this->deleteNotUseQuestion($currentQuestionIds,$questionIds);
		return $poll;
	}
	
	private function getCurrentQuestionIds($pollId){
		if(!$pollId) return FALSE;
		$questions =  $this->getQuestionDao()->findQuestionsByPollId($pollId);
		if(!$questions) return FALSE;
		$Ids = array();
		foreach($questions as $question){
			$Ids[] = $question->questionId;
		}
		return $Ids;
	}
	
	private function deleteNotUseQuestion($currentQuestionIds,$questionIds){
		if(!$currentQuestionIds) return FALSE;
		$diffIds = array_diff($currentQuestionIds,$questionIds);
		if($diffIds){
			$this->getQuestionDao()->deleteQuestions($diffIds);
		}
		return TRUE;
	}
	
	private function updateQuestion($question,$questionId,$pollId){
		$questionId = $this->checkIntParam($questionId);
		$pollId = $this->checkIntParam($pollId);
		if(!$pollId || !$question) return NULL;
		$oQuestion = $this->operateUpdateQuestion($question,$questionId,$pollId);
		$this->updateItem($question['items'],$oQuestion->questionId,$oQuestion->questionType,$pollId);
		return TRUE;
	}
	
	private function operateUpdateQuestion($question,$questionId,$pollId){
		$isExistQuestion = $this->isExistQuestion($questionId,$pollId);
		if($isExistQuestion){
			$question = $this->buildQuestionData($question);
			$this->getQuestionDao()->updateQuestion($question,$questionId);
			return $this->getQuestionDao()->findQuestion($questionId);
		}else{
			$poll = $this->getPollDao()->findPoll($pollId);
			$question['pollId'] = $poll->pollId;
			//$question['questionType'] = $poll->questionType;
			return $this->insertQuestion($question);
		}
	}
	
	private function updateItem($items,$questionId,$questionType,$pollId){
		$pollId = $this->checkIntParam($pollId);
		if(!$pollId || !$questionId) return NULL;
		$currentItemIds = $this->getCurrentItemIds($questionId);
		$itemIds = array();
		foreach($items as $itemId => $item){
			if($itemId) $itemIds[] = $itemId;
			$this->operateUpdateItem($item,$itemId,$questionId,$questionType,$pollId);
		}
		$this->deleteNotUseItem($currentItemIds,$itemIds);
		return TRUE;
	}
	
	private function getCurrentItemIds($questionId){
		if(!$questionId) return NULL;
		$items =  $this->getItemDao()->findItemsByQuestionId($questionId);
		if(!$items) return NULL;
		$Ids = array();
		foreach($items as $item){
			$Ids[] = $item->itemId;
		}
		return $Ids;
	}

	private function deleteNotUseItem($currentItemIds,$itemIds){
		if(!$currentItemIds) return FALSE;
		$diffIds = array_diff($currentItemIds,$itemIds);
		if($diffIds){
			$this->getItemDao()->deleteItems($diffIds);
		}
		return TRUE;
	}	
	
	private function operateUpdateItem($item,$itemId,$questionId,$questionType,$pollId){
		$isExistItem = $this->isExistItem($itemId,$questionId,$pollId);
		if($isExistItem){
			$item = $this->buildItemData($item);
			$item = $this->getItemDao()->updateItem($item,$isExistItem->itemId);
		}else{
			$item['pollId'] = $pollId;
			$item['questionId'] = $questionId;
			$item['questionType'] = $questionType;
			$item = $this->insertItem($item);
		}
		return $item;
	}
	
	private function isExistQuestion($questionId,$pollId){
		$question =  $this->getQuestionDao()->findQuestion($questionId);
		if($question->pollId != $pollId) return FALSE;
		return $question;
	}
	
	private function isExistItem($itemId,$questionId,$pollId){
		$item = $this->getItemDao()->findItem($itemId);
		if(!$item || $item->pollId != $pollId || $item->questionId != $questionId) return FALSE;
		return $item;
	}
	
	private function updatePollByPollId($data,$pollId){
		$data = $this->buildPollData($data);
		if(!$data) return FALSE;
		return $this->getPollDao()->updatePoll($data,$pollId);
	}
	
	private function buildPollData($data){
//		if(!$data) return FALSE;
//		if($data['pollTitle']) $fields['pollTitle'] = trim($data['pollTitle']);
//		$fields['limitType'] = implode($data['limitType'],',');//限制类型
//		if(!$fields['pollTitle'] || !$fields['limitType']) return false;
//		$fields['pollStatus'] = (in_array($data['pollStatus'],$this->pollStatus)) ? $data['pollStatus'] : 'draft';
//		if($data['resultVisiable']) $fields['resultVisiable'] = intval($data['resultVisiable']);
//		if($data['freezeTime']) $fields['freezeTime'] = intval($data['freezeTime']);
//		if($data['startTime']) $fields['startTime'] = $data['startTime'];
//		if($data['endTime']) $fields['endTime'] = $data['endTime'];
//		if($data['resultDisplayOrder']) $fields['resultDisplayOrder'] = intval($data['resultDisplayOrder']);
//		if($data['initCount']) $fields['initCount'] = $data['initCount'];
//		if($data['template']) $fields['template'] = $data['template'];
//		if($data['customTemplate']) $fields['customTemplate'] = $data['customTemplate'];
//		if($data['templateUrl']) $fields['templateUrl'] = $data['templateUrl'];
//		$fields['updateTime'] = time();
//		$fields['updateUser'] = $data['updateUser'];
//		return $fields;	

    	if(!$data) return false;
		$needField = array('pollTitle','limitType','pollStatus');
		if(array_intersect($needField,array_keys($data)) != $needField) return false;
		$fields['pollTitle'] = trim($data['pollTitle']);
		$fields['limitType'] = (is_array($data['limitType'])) ? implode($data['limitType'],',') : $data['limitType'];//限制类型
		if(!$fields['pollTitle'] || !$fields['limitType']) return false;
		$fields['pollStatus'] = (in_array($data['pollStatus'],$this->pollStatus)) ? $data['pollStatus'] : 'draft';
		if($data['resultVisiable']) $fields['resultVisiable'] = intval($data['resultVisiable']);
		if($data['freezeTime']) $fields['freezeTime'] = intval($data['freezeTime']);
		$fields['startTime'] = ($data['startTime']) ? strtotime($data['startTime']) : time();
		if($data['endTime']) $fields['endTime'] = strtotime($data['endTime']);
		if(intval($data['resultDisplayOrder'])) $fields['resultDisplayOrder'] = intval($data['resultDisplayOrder']);
		$fields['initCount'] = ($data['initCount']) ? intval($data['initCount']) : 0;
		if($data['template']) $fields['template'] = $data['template'];
		if($data['customTemplate']) $fields['customTemplate'] = $data['customTemplate'];
		if($data['templateUrl']) $fields['templateUrl'] = $data['templateUrl'];
		//$fields['createTime'] =  time();
		//if($data['createUser']) $fields['createUser'] = $data['createUser'];
		$fields['updateTime'] = time();
		if($data['updateUser']) $fields['updateUser'] = $data['updateUser'];
		return $fields;
	}
	
	private function buildQuestionData($data){
//		if(!$data) return FALSE;
//		if($data['pollId']) $fields['pollId'] = intval($data['pollId']);
//		if($data['title']) $fields['title'] = trim($data['title']);
//		if($data['questionType']) $fields['questionType'] = intval($data['questionType']);
//		if($data['name']) $fields['name'] = $data['name'];
//		if($data['maxMultiOptions']) $fields['maxMultiOptions'] = intval($data['maxMultiOptions']);
//		if($data['required']) $fields['required'] = intval($data['required']);
//		if($data['questionUrl']) $fields['questionUrl'] = $data['questionUrl'];
//		if($data['imgUrl']) $fields['imgUrl'] = $data['imgUrl'];
//		if($data['textField1']) $fields['textField1'] = $data['textField1'];
//		if($data['textField2']) $fields['textField2'] = $data['textField2'];
//		if($data['numField1']) $fields['numField1'] = $data['numField1'];
//		if($data['numField2']) $fields['numField2'] = $data['numField2'];
		
    	if(!$data) return false;
		$needField = array('title','questionType');
		if(array_intersect($needField,array_keys($data)) != $needField) return false;
		$fields['title'] = trim($data['title']);
		$fields['questionType'] = intval($data['questionType']);
		if(!$fields['title'] || !$fields['questionType']) return false;
		if($data['name']) $fields['name'] = $data['name'];
		if($data['maxMultiOptions']) $fields['maxMultiOptions'] = intval($data['maxMultiOptions']);
		if($data['required']) $fields['required'] = intval($data['required']);
		if($data['questionUrl']) $fields['questionUrl'] = $data['questionUrl'];
		if($data['imgUrl']) $fields['imgUrl'] = $data['imgUrl'];
		if($data['textField1']) $fields['textField1'] = $data['textField1'];
		if($data['textField2']) $fields['textField2'] = $data['textField2'];
		if($data['numField1']) $fields['numField1'] = $data['numField1'];
		if($data['numField2']) $fields['numField2'] = $data['numField2'];		
		return $fields;
	}
	
	public function buildItemData($data){
//		if(!$data) return FALSE;
//		if($data['pollId']) $fields['pollId'] = intval($data['pollId']);
//		if($data['questionId']) $fields['questionId'] = intval($data['questionId']);
//		if($data['name']) $fields['name'] = $data['name'];
//		if($data['title']) $fields['title'] = trim($data['title']);
//		if($data['questionType']) $fields['questionType'] = intval($data['questionType']);
//		if($data['initCount']) $fields['initCount'] = intval($data['initCount']);
//		if($data['minLength']) $fields['minLength'] = intval($data['minLength']);
//		if($data['maxLength']) $fields['maxLength'] = intval($data['maxLength']);
//		if($data['fieldType']) $fields['fieldType'] = $data['fieldType'];
//		if($data['imgUrl']) $fields['imgUrl'] = $data['imgUrl'];
//		if($data['itemUrl']) $fields['itemUrl'] = $data['itemUrl'];
//		return $fields;

		if(!$data) return FALSE;
		$needField = array('title');
		if(array_intersect($needField,array_keys($data)) != $needField) return FALSE;
		$fields['name'] = $data['name'];
		$fields['title'] = trim($data['title']);
		if(!$fields['title']) return FALSE;
		if($data['questionType']) $fields['questionType'] = intval($data['questionType']);
		if($data['initCount']) $fields['initCount'] = intval($data['initCount']);
		if($data['minLength']) $fields['minLength'] = intval($data['minLength']);
		if($data['maxLength']) $fields['maxLength'] = intval($data['maxLength']);
		if($data['fieldType']) $fields['fieldType'] = $data['fieldType'];
		if($data['imgUrl']) $fields['imgUrl'] = $data['imgUrl'];
		if($data['itemUrl']) $fields['itemUrl'] = $data['itemUrl'];
		return $fields;
	}
	
	/****************************获取投票列表**************************************/	
	
	public function getPolls($offset,$limit){
		return $this->getPollDao()->findPolls($offset,$limit);
	}
	
	/**********************用户参与投票部分*********************************/
	
	public function attendPoll(array $questions,$pollId){
		$questions = $this->checkAttend($questions);
		if(!$questions) return NULL;
		return $this->insertAttend($questions,$pollId);
	}
	
	//检查投票数据 获取q_xx数据 如果数据中有不存在的ID，则直接退出
	private function checkAttend($questions){
		if(!$questions) return NULL;
		$data = array();
		foreach($questions as $key=>$item){
			$question = explode('_',$key);
			if($question[0] == 'q'){
				$data[$question[1]] = $item;
			}
		}
		return $this->checkAttendQuestion($data);
	}
	
	//检查参与问题数据
	private function checkAttendQuestion(array $questions){
		if(!$questions) return NULL;
		$data = array();
		foreach($questions as $questionId=>$item){
			$data[$questionId] = $this->checkAttendItem($questionId,$item);
			if(!$data[$questionId]) return FALSE;
		}
		return $data;
	}
	
	//检查参与项目数据
	private function checkAttendItem($questionId,$item){
		$question = $this->getQuestionDao()->findQuestion($questionId);
		if($question){
			$item = $this->checkType($question->questionType,$item);
			if(!$item) return FALSE;
		}
		return $item;
	}
	
	//根椐投票类型检查数据
	private function checkType($type,$item){
		switch ($type){
			case 1:
			case 2:
				return $this->checkOpt($item);
				break;
			case 3:
			case 4:
				return $this->checkText($item);
				break;
			default:
				break;
		}
		return FALSE;
	}
	
	//检查选择类数据
	private function checkOpt($itemIds){
		if(!$itemIds) return NULL;
		if(!is_array($itemIds)){
			$Ids =  $this->checkAttendItemId($itemIds);
			if($Ids) return $Ids;
		}else{
			foreach($itemIds as $itemId){
				$Ids[] = $this->checkAttendItemId($itemId);
			}
			if($Ids) return $Ids;
		}
		return FALSE;
	}
	
	//检查文本类数据
	private function checkText($item){
		$item = trim($item);
		if(!$item) return FALSE;
		return $item;
	}
	
	//检查每一个选项ID是否存在
	private function checkAttendItemId($itemId){
		if(!$itemId) return FALSE;
		$item = $this->getItemDao()->findItem($itemId);
		if($item) return $itemId;
		return FALSE;
	}
	
	private function insertAttend($questions,$pollId){
		if(!$questions) return NULL;
		$data = array();
		foreach($questions as $questionId => $item){
			$data[$questionId] = $this->saveType($item,$questionId,$pollId);
		}
		return $data;
	}
	
	private function saveType($item,$questionId,$pollId){
		$question = $this->getQuestionDao()->findQuestion($questionId);
		if(!$question) return NULL;
		switch ($question->questionType){
			case 1:
			case 2:
				return $this->saveOpt($item,$questionId,$pollId);
				break;
			case 3:
			case 4:
				return $this->saveText($item,$questionId,$pollId);
				break;
			default:
				break;
		}
		return FALSE;		
	}
	
	private function saveText($item,$questionId,$pollId){
		$items = $this->getItemDao()->findItemsByQuestionId($questionId);
		if(!$items) return NULL;
		$itemId = $items[0]->itemId;
		$fields = array('pollId'=>$pollId,'questionId'=>$questionId,'itemId'=>$itemId,'answer'=>$item);
		$answer = $this->addAnswer($fields);
		$this->insertAttendResult($itemId,$questionId,$pollId);
		return $answer;
	}
	
	private function saveOpt($item,$questionId,$pollId){
		if(is_array($item)){
			foreach($item as $itemId){
				$data[] = $this->saveOptRelate($itemId,$questionId,$pollId);
			}
			return $data;
		}
		return $this->saveOptRelate($item,$questionId,$pollId);
	}
	
	private function saveOptRelate($itemId,$questionId,$pollId){
		$fields = array('pollId'=>$pollId,'questionId'=>$questionId,'itemId'=>$itemId,'answer'=>'');
		$answer = $this->addAnswer($fields);
		$this->insertAttendResult($itemId,$questionId,$pollId);
		return $answer;
	}
	
	private function insertAttendResult($itemId,$questionId,$pollId){
		$itemId = $this->checkIntParam($itemId);
		if(!$itemId) return NULL;
		if($this->getResultDao()->findResultsByItemId($itemId)){
			$this->getResultDao()->updateResultCount(1,$itemId);
		}else{
			$fields = array('pollId'=>$pollId,'questionId'=>$questionId,'itemId'=>$itemId,'pollCounts'=>1);
			$this->addResult($fields);
		}
		return TRUE;
	}
	
	private function addAnswer(array $fields){
		$fields = $this->checkAnswer($fields);
		if(!$fields) return NULL;
		return $this->getAnswerDao()->addAnswer($fields);
	}
	
	private function checkAnswer($fields){
		if(!$fields) return FALSE;
		$needField = array('pollId','questionId','itemId','answer');
		if(array_intersect($needField,array_keys($fields)) != $needField) return FALSE;
		$data['pollId'] = intval($fields['pollId']);
		$data['questionId'] = intval($fields['questionId']);
		$data['itemId'] = intval($fields['itemId']);
		$data['answer'] = $fields['answer'];
		$data['voteIp'] = $fields['voteIp'];
		$data['username'] = $fields['username'];
		$data['pollTime'] = time();
		return $data;
	}
	
	
	private function addResult(array $fields){
		$fields = $this->checkResult($fields);
		if(!$fields) return NULL;
		return $this->getResultDao()->addResult($fields);
	}
	
	private function checkResult($fields){
		if(!$fields) return FALSE;
		$needField = array('pollId','questionId','itemId','pollCounts');
		if(array_intersect($needField,array_keys($fields)) != $needField) return FALSE;
		$data['pollId'] = intval($fields['pollId']);
		$data['questionId'] = intval($fields['questionId']);
		$data['itemId'] = intval($fields['itemId']);
		$data['pollCounts'] = $fields['pollCounts'];
		return $data;
	}
	
	/****************************获取投票结果**************************************/
	
	public function getVoting($pollId){
		$pollId = $this->checkIntParam($pollId);
		if(!$pollId) return NULL;
		$poll = $this->getPoll($pollId);
		$poll->questions = $this->votingQuestion($poll->questions);
		return $poll;
	}
	
	private function votingQuestion($questions){
		if(!$questions) return NULL;
		foreach($questions as $question){
			$question->items = $this->votingItem($question->items);
			$newQuestion[] = $question;
		}
		return $newQuestion;
	}
	
	private function votingItem(array $items){
		if(!$items) return NULL;
		foreach($items as $item){
			$result = $this->getResultDao()->findResultsByItemId($item->itemId);
			$item->pollCounts = intval($result->pollCounts);
			$newItem[] = $item;
		}
		return $newItem;
	}
	
	public function getQuestionResult($questionId){
		//
	}
	
	private function votingAnswer($itemId){
		return $this->getAnswerDao()->findAnswersByItemId($itemId);
	}
	
	//复制投票
	public function copyPoll(array $pollData){
		return $this->addPoll($pollData);
	}
	
	//查询投票
	public function searchPolls($value,$type,$offset=0, $limit=30){
		if($type == 2){
			return $this->getPollDao()->searchPollsByAuthor($value,$offset, $limit);
		}else{
			return $this->getPollDao()->searchPollsByTitle($value,$offset, $limit);
		}
	}
	
	private function checkIntParam($param){
		$param = intval($param);
		if($param == 0 ) return FALSE;
		return $param;
	}
	
	private function getPollDao(){
		require_once 'zigu/poll/dao/PollDaoFactory.php';
		return PollDaoFactory::getInstance()->createPollDao();
	}
	
	private function getQuestionDao(){
		require_once 'zigu/poll/dao/PollDaoFactory.php';
		return PollDaoFactory::getInstance()->createPollQuestionDao();
	}
	
	private function getItemDao(){
		require_once 'zigu/poll/dao/PollDaoFactory.php';
		return PollDaoFactory::getInstance()->createPollItemDao();
	}
	
	private function getAnswerDao(){
		require_once 'zigu/poll/dao/PollDaoFactory.php';
		return PollDaoFactory::getInstance()->createPollAnswerDao();
	}
	
	private function getResultDao(){
		require_once 'zigu/poll/dao/PollDaoFactory.php';
		return PollDaoFactory::getInstance()->createPollResultDao();
	}
	
	
	
}