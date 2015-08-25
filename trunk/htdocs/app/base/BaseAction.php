<?php

abstract class BaseAction {
    abstract public function execute();
    
    protected function render($scriptName) {
        $viewScriptFilePath = APP_ROOTPATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $scriptName . '.phtml';
        include $viewScriptFilePath;
    }
    
    public function getPollService(){
    	require_once 'zigu/poll/service/PollServiceFactory.php';
		return PollServiceFactory::getInstance()->createPollService();
    }
    
    public function redirect($message,$href=NULL){
    	$this->message = $message;
    	$this->url = ($href) ? $href : 'error.php';
    	header('Location:'.$this->url);
    }
    
    public function getCurrentUser(){
    	return 'test_19lou';
    }
}