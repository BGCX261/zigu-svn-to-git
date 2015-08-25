<?php
require_once APP_ROOTPATH . DIRECTORY_SEPARATOR . 'base' . DIRECTORY_SEPARATOR .'BaseAction.php';
class PollResultAction extends BaseAction {
    
    public function execute() {
		$pollId = intval($_GET['pollId']);
		$this->poll = $poll = $this->getPollService()->getVoting($pollId);
		if(!$poll) echo '投票不存在';
		$this->pollLimit = array('不限制','IP限制','用户限制','ip与用户限制','用户时间限制','ip时间限制','用户等级限制','用户登陆限制','用户注册时间限制');
		$resultVisiable = $poll->resultVisiable;
		$this->resultDisplayOrder = array(1=>'按录入顺序排序',2=>'按票数从高到低',3=>'按票数从低到高');
		$this->resultHtml = $this->getResultHTML($poll);
		$this->render('poll/pollresult');
    }
    
    public function getResultHTML($poll){
	    $i = 1;
	    foreach($poll->questions as $question){ 
			$html .= '<dl>';
			$html .= '<dd>问题'.$i.'：'.$question->title.'类型：'.$this->questionType[$question->questionType].'</dd>';
			$html .= $this->createVotingHtml($question->items,$question->questionType,$question->questionId);
			$html .= '</dl>';
			$i++;
		}
		return $html;
    }
    
    private $questionType = array(1=>'单选',2=>'多选',3=>'文本',4=>'文本区域');
    
	public function createVotingHtml($items){
		if(!$items) return '';
		$html = '';
		foreach($items as $item){
			$html .= '<dd>选项：'.$item->title.'	参与数：'.$item->pollCounts.'</dd>';
		}
		return $html;
	}
}