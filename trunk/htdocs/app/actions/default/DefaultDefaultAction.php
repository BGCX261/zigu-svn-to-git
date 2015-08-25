<?php

require_once APP_ROOTPATH . DIRECTORY_SEPARATOR . 'base' . DIRECTORY_SEPARATOR .'BaseAction.php';

class DefaultDefaultAction extends BaseAction {
    public function execute() {
	    $this->polls = $this->getPollService()->getPolls(0,30);
		$this->hasPoll = ($this->polls) ? TRUE : FALSE;
		$this->pollStatus = $this->getPollStatus();
		$this->resultVisiable = $this->getPollResultVisiable();
        $this->render('default');
    }
    
    public function getPollStatus(){
    	return array('online'=>'正式','offline'=>'关闭','ing'=>'进行中','draft'=>'草稿',);
    }
    
    public function getPollResultVisiable(){
    	return array('是','否');
    }
}