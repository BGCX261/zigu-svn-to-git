<?php
class PollDaoFactory {
	private static $instance = NULL;
	private $daoPool  = NULL;
	
	public static function getInstance(){
		if(!self::$instance){
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	/**
	 * @return PollDao
	 */
	public function createPollDao(){
		if(isset($this->daoPool['pollDAO'])){
			return $this->daoPool['pollDAO'];
		}
		require_once 'zigu/poll/dao/impl/PollDaoImpl.php';
		$this->daoPool['pollDAO'] = new PollDaoImpl();
		return $this->daoPool['pollDAO'];
	}
	
	public function createPollQuestionDao(){
		if(isset($this->daoPool['pollQuestionDAO'])){
			return $this->daoPool['pollQuestionDAO'];
		}
		require_once 'zigu/poll/dao/impl/PollQuestionDaoImpl.php';
		$this->daoPool['pollQuestionDAO'] = new PollQuestionDaoImpl();
		return $this->daoPool['pollQuestionDAO'];
	}
	
	public function createPollItemDao(){
		if(isset($this->daoPool['pollItemDAO'])){
			return $this->daoPool['pollItemDAO'];
		}
		require_once 'zigu/poll/dao/impl/PollItemDaoImpl.php';
		$this->daoPool['pollItemDAO'] = new PollItemDaoImpl();
		return $this->daoPool['pollItemDAO'];
	}
	
	public function createPollAnswerDao(){
		if(isset($this->daoPool['pollAnswerDAO'])){
			return $this->daoPool['pollAnswerDAO'];
		}
		require_once 'zigu/poll/dao/impl/PollAnswerDaoImpl.php';
		$this->daoPool['pollAnswerDAO'] = new PollAnswerDaoImpl();
		return $this->daoPool['pollAnswerDAO'];
	}
	
	public function createPollResultDao(){
		if(isset($this->daoPool['pollResultDAO'])){
			return $this->daoPool['pollResultDAO'];
		}
		require_once 'zigu/poll/dao/impl/PollResultDaoImpl.php';
		$this->daoPool['pollResultDAO'] = new PollResultDaoImpl();
		return $this->daoPool['pollResultDAO'];
	}
}