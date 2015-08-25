<?php
require_once APP_ROOTPATH . DIRECTORY_SEPARATOR . 'base' . DIRECTORY_SEPARATOR .'BaseAction.php';
class PollCopyAction extends BaseAction {
    
    public function execute() {
        if($_POST['action'] == 'edit'){
        	$pollData = $this->checkAddPollData($_POST);
			if(!$pollData) echo '投票数据有误，请重试！';
			$poll = $this->getPollService()->copyPoll($pollData);
			if($poll){
				header('Location:index.php');
			}else{
				echo '复制失败';
			}
		}
	    $this->pollId= $_GET['pollId'];
		$this->poll = $poll = $this->getPollService()->getPoll($this->pollId);
		//$pollLimit = array('不限制','IP限制','用户限制','ip与用户限制','用户时间限制','ip时间限制','用户等级限制','用户登陆限制','用户注册时间限制');
		$limitType = explode(',',$poll->limitType);
		$this->limitType = array('0'=>(in_array(0,$limitType)) ? 'checked' : '',
							 '1'=>(in_array(1,$limitType)) ? 'checked' : '',
							 '2'=>(in_array(2,$limitType)) ? 'checked' : '',
							 '3'=>(in_array(3,$limitType)) ? 'checked' : '',
						 	 '4'=>(in_array(4,$limitType)) ? 'checked' : '',
							 '5'=>(in_array(5,$limitType)) ? 'checked' : '',
							 '6'=>(in_array(6,$limitType)) ? 'checked' : '',
							);
		$this->statusSelect = array('draft'=>($poll->pollStatus == 'draft') ? 'selected' : '',
							  'online'=>($poll->pollStatus == 'online') ? 'selected' : '',
							  'ing'=>($poll->pollStatus == 'ing') ? 'selected' : '',
							  'offline'=>($poll->pollStatus == 'offline') ? 'selected' : '',	
							);
							
		$this->displayOrderSelect = array('1'=>($poll->resultDisplayOrder == 1) ? 'selected' : '',
									'2'=>($poll->resultDisplayOrder == 2) ? 'selected' : '',
									'3'=>($poll->resultDisplayOrder == 3) ? 'selected' : '',
									);
		$resultVisiable = $poll->resultVisiable;
		$this->resultDisplayOrder = array(1=>'按录入顺序排序',2=>'按票数从高到低',3=>'按票数从低到高');
		$this->resultVisiable = ($poll->resultVisiable) ? 'checked' : '';
		$this->questions = $this->createEditHtml($poll->questions);
		$this->startTime = date("Y-m-d",$this->poll->startTime);
		$this->endTime = date("Y-m-d",$this->poll->endTime);
		$this->render('poll/pollcopy');
    }
	
	public function createItemHtml($items,$type,$questionId){
		if(!$items) return '';
		$html = '';
		foreach($items as $item){
			$html .= $this->getHtmlByQuestionType($type,$questionId,$item->itemId,$item->title);
		}
		return $html;
	}
	
	public function createEditHtml($questions){
		$html = '';
		foreach($questions as $question){
			$html .= $this->createEditQuestionHtml($question);
		}
		return $html;
	}
	
	public function createEditQuestionHtml($question){
		$id = $question->questionId;
		$select = array('1'=>($question->questionType == 1) ? 'selected' : '',
						'2'=>($question->questionType == 2) ? 'selected' : '',
						'3'=>($question->questionType == 3) ? 'selected' : '',
						'4'=>($question->questionType == 4) ? 'selected' : '',
						);
		$html  =  '<div id="question_'.$id.'">';
		$html .= '<div>问题'.$id.'：<input type="text" name="questions['.$id.'][title]" value="'.$question->title.'" />';
		$html .= '&nbsp;类型：<select name="questions['.$id.'][questionType]" id="select_'.$id.'" ><option value="1" '.$select['1'].'>单选</option><option value="2" '.$select['2'].'>多选</option><option value="3" '.$select['3'].'>文本</option><option value="4" '.$select['4'].'>文本区域</option></select>';
		$html .= '<input type="button" value="高级设置" id="advq_'.$id.'" />';
		$html .= '<div id="newq_'.$id.'" />';//IE不兼容，用span
		$html .= $this->createEditQuestionSetting($question,$id);
		$html .= '</div>';
		
		$html .= '<div id="item_'.$id.'">'.$this->createEditItemHtml($question->items,$question->questionType).'</div>';
		if($question->questionType == 1 || $question->questionType == 2 ){
			$html .= '<div>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="增加选项"  id="add_'.$id.'"/></div>';
		}
		$html .= '</div></div>';
		return $html;
	}
	
	public function createEditQuestionSetting($question,$id){
		$checked = ($question->required == 1) ? 'checked' : '';
		$questionUrl = ($question->questionUrl) ? $question->questionUrl : '';
		$imgUrl = ($question->imgUrl) ? $question->imgUrl : '';
		$html  = '<div id="layerQuestion_'.$id.'" style="'.$this->setCss().'">';
		$html .= '<dd>问题高级设置</dd>';
		if($question->questionType == 2) {
			$html .= '<dd>多选限制数：<input type="text" name="questions['.$id.'][maxMultiOptions]" value="'.$question->maxMultiOptions.'" /></dd>';
		}
		$html .= '<dd>问题是否必填：<input type="checkbox" name="questions['.$id.'][required]" value="" '.$checked.' /></dd>';
		$html .= '<dd>问题URL：<input type="text" name="questions['.$id.'][questionUrl]" value="'.$questionUrl.'" /></dd>';
		$html .= '<dd>图片URL：<input type="text" name="questions['.$id.'][imgUrl]" value="'.$imgUrl.'" /></dd>';
		$html .= '<dd><input type="button" value="确定" id="addAdvQuestion_'.$id.'" /><input type="button" value="关闭" id="closeAdvQuestion_'.$id.'" /></dd>';
		$html .= '</div>';
		return $html;
	}
	
	public function setCss(){
		return 'display:none;position: absolute;left:500px;top:300px;width:400px;background-color:#f0f5FF;border: 1px solid #000;z-index: 50;padding:10px';
	}
	
	public function createEditItemHtml($items,$type){
		if ($type == '1' ) {
			return $this->createTextHtml($items);
		}elseif($type == '2'){
			return $this->createTextHtml($items); 
		}elseif($type == '4'){
			return $this->createTextAreaHtml($items);
		}else{
			return $this->createTextAreaHtml($items);
		}
	}
	
	public function createTextHtml($items){
		$html = '';
		foreach($items as $item){
			//$html .= '<dd>选项：<input type="text" name="questions['.$item->questionId.'][items]['.$item->itemId.'][title]" value="'.$item->title.'" /><input type="button" value="删除" id="del_'.$item->questionId.'" /></dd>';
			$html .= $this->textHtml($item);
		}
		return $html;
	}
	
	public function createTextAreaHtml($items){
		$html = '';
		foreach($items as $item){
			//$html .= '<dd><textarea name="questions['.$item->questionId.'][items]['.$item->itemId.'][title]" value="'.$item->title.'" >'.$item->title.'</textarea></dd>';
			$html .= $this->textAreaHtml($item);
		}
		return $html;
	}
	
	public function textHtml($item){
		$questionId = $item->questionId;
		$itemId = $item->itemId;
		$html  = '<div id="option_'.$itemId.'">选项';
		$html .= '<input type="text" name="questions['.$questionId.'][items]['.$itemId.'][title]" value="'.$item->title.'" />';
		$html .= '<input type="button" value="删除" id="del_'.$questionId.'" />';
		$html .= '<input type="button" value="高级设置" id="advi_'.$questionId.'" />';
		$html .= '<span id="newi_'.$itemId.'" />';//IE不兼容，用span
		$html .= $this->createEditItemSetting($item);
		$html .= '</span>';
		$html .= '</div>';
		return $html;
	}
	
	public function textAreaHtml($item){
		$questionId = $item->questionId;
		$itemId = $item->itemId;
		$html  = '<div id="option_'.$itemId.'">';
		$html .= '<textarea name="questions['.$questionId.'][items]['.$itemId.'][title]" value="'.$item->title.'" >'.$item->title.'</textarea>';
		$html .= '<input type="button" value="高级设置" id="advi_'.$questionId.'" />';
		$html .= '<span id="newi_'.$itemId.'" />';//IE不兼容，用span
		$html .= $this->createEditItemSetting($item);
		$html .= '</span>';
		$html .= '</div>';
		return $html;
	}
	
	
	public function createEditItemSetting($item){
		$questionId = $item->questionId;
		$itemId = $item->itemId;
		$html  = '<div id="layer_'.$itemId.'" style="'.$this->setCss().'">';
		$html .= '<dd>选项高级设置</dd>';
		$html .= '<dd>初始值：<input type="text" name="questions['.$questionId.'][items]['.$itemId.'][initCount]" value="'.$item->title.'" /></dd>';
		if($item->type == 3 || $item->type == 4){
			$html .= '<dd>选项输入最小值：<input type="text" name="questions['.$questionId.'][items]['.$itemId.'][minLength]" value="'.$item->minLength.'" /></dd>';
			$html .= '<dd>选项输入最大值：<input type="text" name="questions['.$questionId.'][items]['.$itemId.'][maxLength]" value="'.$item->maxLength.'" /></dd>';
		}
		$html .= '<dd>图片URL：<input type="text" name="questions['.$questionId.'][items]['.$itemId.'][imgUrl]" value="'.$item->imgUrl.'" /></dd>';
		$html .= '<dd>问题URL：<input type="text" name="questions['.$questionId.'][items]['.$itemId.'][itemUrl]" value="'.$item->itemUrl.'" /></dd>';
		$html .= '<dd><input type="button" value="确定" id="addAdv_'.$itemId.'" /><input type="button" value="关闭" id="closeAdv_'.$itemId.'" /></dd>';
		$html .= '</div>';
		return $html;
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
		if($data['createUser']) $fields['createUser'] = $data['createUser'];
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