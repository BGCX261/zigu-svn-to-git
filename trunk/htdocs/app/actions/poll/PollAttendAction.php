<?php

require_once APP_ROOTPATH . DIRECTORY_SEPARATOR . 'base' . DIRECTORY_SEPARATOR .'BaseAction.php';

class PollAttendAction extends BaseAction {
    
    public function execute() {
	    $pollId = $_GET['pollId'];
		$this->poll = $poll = $this->getPollService()->getPoll($pollId);
		$this->pollLimit = array('不限制','IP限制','用户限制','时间限制','等级限制','登陆限制','注册时间限制');
		//是否显示投票页 投票权限检查
		$this->resultVisiable = $poll->resultVisiable;
		$this->resultDisplayOrder = array(1=>'按录入顺序排序',2=>'按票数从高到低',3=>'按票数从低到高');
		$this->questions = $this->createQuestion($poll);
		if($_POST['action']=='vote'){
			$pollId = intval($_GET['pollId']);
			if(!$pollId) echo '投票ID不能为空';
			$saved = $this->getPollService()->attendPoll($_POST,$pollId);
			if($saved){
				echo '投票成功';
			}else{
				echo '投票失败';
			}
		}
		//调用模板
        $this->render('poll/pollattend');
    }
    
    public function createQuestion($poll){
    	$html = '';
    	$i = 1;
    	foreach($poll->questions as $question){ 
    		$require = ($question->required) ? '是' : '否';
			$html .= '<dl>';
			$html .= '<dd>问题'.$i.'：'.$question->title.'是否必填：'.$require.'</dd>';
			$html .= $this->createItemHtml($question->items,$question->questionType,$question->questionId);
			$html .= '</dl>';
			$i++;
    	}
    	return $html;
    }
	
	public function createItemHtml($items,$type,$questionId){
		if(!$items) return '';
		$html = '';
		foreach($items as $item){
			$html .= $this->getHtmlByQuestionType($type,$questionId,$item->itemId,$item->title);
		}
		return $html;
	}
	
	public function getHtmlByQuestionType($type,$questionId,$itemId,$title){
		if ($type == '1' ) {
			return $this->createRadioHtml($questionId,$itemId,$title);
		}elseif($type == '2'){
			return $this->createCheckBoxHtml($questionId,$itemId,$title); 
		}elseif($type == '4'){
			return $this->createTextAreaHtml($questionId,$itemId);
		}else{
			return $this->createTextAreaHtml($questionId,$itemId);
		}
	}
	
	public function createRadioHtml($questionId,$itemId,$title){
		return '<dd><input type="radio" name="q_'.$questionId.'" value="'.$itemId.'" />'.$title.'</dd>';
	}
	
	public function createCheckBoxHtml($questionId,$itemId,$title){
		return '<dd><input type="checkbox" name="q_'.$questionId.'[]" value="'.$itemId.'" />'.$title.'</dd>';
	}
	
	public function createTextAreaHtml($questionId,$itemId){
		return '<textarea name="q_'.$questionId.'"></textarea>';
	}
	
	public function createTextHtml($questionId,$itemId){
		return '<input type="text" name="q_'.$questionId.'" value="" />';
	}
}