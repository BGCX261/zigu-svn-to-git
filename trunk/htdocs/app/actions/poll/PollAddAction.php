<?php

require_once APP_ROOTPATH . DIRECTORY_SEPARATOR . 'base' . DIRECTORY_SEPARATOR .'BaseAction.php';

class PollAddAction extends BaseAction {
    
    public function execute() {
		if(strtolower($_SERVER['REQUEST_METHOD']) == 'post'){
			$pollData = $this->checkAddPollData($_POST);
			if(!$pollData) echo '投票数据有误，请重试！';
			$poll = $this->getPollService()->addPoll($pollData);
			if($poll){
				header('Location:index.php');
			}else{
				echo '投票失败';
			}
		}
		$this->currentDate = date('Y-m-d',time());
        $this->render('poll/polladd');
    }
    
    private $pollStatus = array('draft','online','ing','offline');
    
    private function checkAddPollData($data){
    	if(!$data) return false;
    	$fields['questions'] = $this->checkAddQuestionData($data['questions']);
    	if(empty($fields['questions'])) return false;//问题为空
		$needField = array('pollTitle','limitType','pollStatus');
		if(array_intersect($needField,array_keys($data)) != $needField) return false;
		$fields['pollTitle'] = trim($data['pollTitle']);
		$fields['limitType'] = implode($data['limitType'],',');//限制类型
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
		$fields['createTime'] =  time();
		$fields['createUser'] = $this->getCurrentUser();
		//$fields['updateTime'] = time();
		//if($data['updateUser']) $fields['updateUser'] = $data['updateUser'];
		return $fields;
    }
    
    private function checkAddQuestionData($data){
    	if(empty($data)) return false;
    	$newData = array();
    	foreach($data as $question){
    		$question = $this->checkQuestion($question);
    		if(empty($question)) return false;
    		$newData[] = $question;
    	}
    	return $newData;
    }
    
    private function checkQuestion($data){
    	if(!$data) return false;
    	$fields['items'] = $this->checkAddItemData($data['items']);
    	if(empty($fields['items'])) return FALSE;
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
    
    private function checkAddItemData($data){
    	if(empty($data)) return false;
    	$newData = array();
    	foreach($data as $item){
    		$item = $this->checkItem($item);
    		if(empty($item)) return false;
    		$newData[] = $item;
    	}
    	return $newData;
    }
    
	private function checkItem(array $data){
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
}