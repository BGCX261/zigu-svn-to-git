<?php

require_once 'zigu/ZiguBaseTestCase.php';
require_once 'zigu/poll/dao/PollConnectionFactory.php';

class PollBaseTestCase extends ZiguBaseTestCase {
    
    protected function fillPollTable() {
        $this->truncatePollTable();
        $rows = $this->getPollDataGenerator()->getAll();
        foreach ($rows as $row) {
            $this->getPollDao()->addPoll($row);
        }
    }
    
	protected function truncatePollTable(){
		$sql = "TRUNCATE TABLE ".$this->getPollDataGenerator()->getTablename();
		PollConnectionFactory::getInstance()->getConnection()->exec($sql);
	}
    
	protected function getPollDao(){
		return PollDaoFactory::getInstance()->createPollDao();
	}
	
    protected function fillResultTable() {
        $this->truncateResultTable();
        $rows = $this->getResultDataGenerator()->getAll();
        foreach ($rows as $row) {
            $this->getResultDao()->addResult($row);
        }
    }
    
	protected function truncateResultTable(){
		$sql = "TRUNCATE TABLE ".$this->getResultDataGenerator()->getTablename();
		PollConnectionFactory::getInstance()->getConnection()->exec($sql);
	}
    
	protected function getResultDao(){
		return PollDaoFactory::getInstance()->createPollResultDao();
	}
	
	
    protected function fillQuestionTable() {
        $this->truncateQuestionTable();
        $rows = $this->getQuestionDataGenerator()->getAll();
        foreach ($rows as $row) {
            $this->getQuestionDao()->addQuestion($row);
        }
    }
    
	protected function truncateQuestionTable(){
		$sql = "TRUNCATE TABLE ".$this->getQuestionDataGenerator()->getTablename();
		PollConnectionFactory::getInstance()->getConnection()->exec($sql);
	}
    
	protected function getQuestionDao(){
		return PollDaoFactory::getInstance()->createPollQuestionDao();
	}
	
    protected function fillAnswerTable() {
        $this->truncateAnswerTable();
        $rows = $this->getAnswerDataGenerator()->getAll();
        foreach ($rows as $row) {
            $this->getAnswerDao()->addAnswer($row);
        }
    }
    
	protected function truncateAnswerTable(){
		$sql = "TRUNCATE TABLE ".$this->getAnswerDataGenerator()->getTablename();
		PollConnectionFactory::getInstance()->getConnection()->exec($sql);
	}
    
	protected function getAnswerDao(){
		return PollDaoFactory::getInstance()->createPollAnswerDao();
	}
	
    protected function fillItemTable() {
        $this->truncateItemTable();
        $rows = $this->getItemDataGenerator()->getAll();
        foreach ($rows as $row) {
            $this->getItemDao()->addItem($row);
        }
        return $rows;
    }
    
	protected function truncateItemTable(){
		$sql = "TRUNCATE TABLE ".$this->getItemDataGenerator()->getTablename();
		PollConnectionFactory::getInstance()->getConnection()->exec($sql);
	}
    
	protected function getItemDao(){
		return PollDaoFactory::getInstance()->createPollItemDao();
	}
	
	
   /**
     * @return PollDataGenerator
     */
    protected function getPollDataGenerator() {
        require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '_files'. DIRECTORY_SEPARATOR . 'PollDataGenerator.php';
        return new PollDataGenerator();
    }
    
    /**
     * @return PollQuestionDataGenerator
     */
    protected function getQuestionDataGenerator() {
        require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '_files'. DIRECTORY_SEPARATOR . 'QuestionDataGenerator.php';
        return new QuestionDataGenerator();
    }
    
    /**
     * @return PollAnswerDataGenerator
     */    
    protected function getAnswerDataGenerator() {
        require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '_files'. DIRECTORY_SEPARATOR . 'AnswerDataGenerator.php';
        return new AnswerDataGenerator();
    }
    
    /**
     * @return PollResultDataGenerator
     */    
    protected function getResultDataGenerator() {
        require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '_files'. DIRECTORY_SEPARATOR . 'ResultDataGenerator.php';
        return new ResultDataGenerator();
    }
    
    /**
     * @return PollItemDataGenerator
     */    
    protected function getItemDataGenerator() {
        require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '_files'. DIRECTORY_SEPARATOR . 'ItemDataGenerator.php';
        return new ItemDataGenerator();
    }
}