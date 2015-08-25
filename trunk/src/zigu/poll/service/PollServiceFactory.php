<?php
class PollServiceFactory {
	private static $instance = NULL;
	private $servicePool  = NULL;
	
	public static function getInstance(){
		if(!self::$instance){
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function createPollService(){
		if($this->servicePool['PollService']){
			return $this->servicePool['PollService'];
		}
		require_once 'zigu/poll/service/impl/PollServiceImpl.php';
		$this->servicePool['PollService'] = new PollServiceImpl();
		return $this->servicePool['PollService'];
	}
}