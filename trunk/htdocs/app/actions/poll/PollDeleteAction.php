<?php
require_once APP_ROOTPATH . DIRECTORY_SEPARATOR . 'base' . DIRECTORY_SEPARATOR .'BaseAction.php';
class PollDeleteAction extends BaseAction {
    
    public function execute() {
        $pollId = intval($_GET['pollId']);
		$delete = $this->getPollService()->deletePoll($pollId);
		if($delete){
			echo '删除成功';
		}else{
			echo '删除失败';
		}
    }
}