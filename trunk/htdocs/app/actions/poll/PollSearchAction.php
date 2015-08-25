<?php
require_once APP_ROOTPATH . DIRECTORY_SEPARATOR . 'base' . DIRECTORY_SEPARATOR .'BaseAction.php';
class PollSearchAction extends BaseAction {
    
    public function execute() {
    	if($_POST['action'] == 'search'){
    		$search = $_POST['search'];
    		$searchType = $_POST['searchType'];
    		$poll = $this->getPollService()->searchPolls($search,$searchType);
    		$this->hasPoll = ($poll) ? TRUE : FALSE;
    		$this->polls = ($poll) ? $poll : '';
    	}
		$this->render('poll/pollsearch');
    }
	
    
}