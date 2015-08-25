<?php

require_once 'zigu/poll/dao/PollAnswerDao.php';
require_once 'zigu/poll/dao/PollBaseDao.php';

class PollAnswerDaoImpl extends PollBaseDao implements PollAnswerDao  {
    private $tableName = 'zigu_pollanswers';
	
	public function addAnswer(array $data){
	    $sql = $this->getInsertSql($this->getAnswerTableName(), array_keys($data));
	    $stmt = $this->getConnection()->prepare($sql);
	    $this->bindParams($stmt, $data);
	    $stmt->execute();
	    return $stmt->rowCount() == 1 ? $this->findAnswer($this->getConnection()->lastInsertId()) : null;
	}
	
	public function findAnswer($answerId){
		$sql = "SELECT * FROM {$this->getAnswerTableName()} WHERE answerId=:answerId";
		$stmt=$this->getConnection()->prepare($sql);
		$stmt->bindParam(':answerId', $answerId, PDO::PARAM_INT);
		$stmt->execute();
		$found = $stmt->fetch(PDO::FETCH_OBJ);
		return empty($found) ? null : $found;
	}
	
	public function findAnswersByPollId($pollId){
		$sql = "SELECT * FROM {$this->getAnswerTableName()} WHERE pollId=:pollId";
		$stmt=$this->getConnection()->prepare($sql);
		$stmt->bindParam(':pollId', $pollId, PDO::PARAM_INT);
		$stmt->execute();
		$found = $stmt->fetchAll(PDO::FETCH_OBJ);
		return empty($found) ? null : $found;
	}
	
	public function findAnswersByItemId($itemId){
		$sql = "SELECT * FROM {$this->getAnswerTableName()} WHERE itemId=:itemId";
		$stmt=$this->getConnection()->prepare($sql);
		$stmt->bindParam(':itemId', $itemId, PDO::PARAM_INT);
		$stmt->execute();
		$found = $stmt->fetchAll(PDO::FETCH_OBJ);
		return empty($found) ? null : $found;
	}
	
	public function updateAnswer(array $data, $answerId){
	    $sql = $this->getUpdateSql($this->getAnswerTableName(), array_keys($data), 'answerId=:answerId');
		$stmt=$this->getConnection()->prepare($sql);
		$this->bindParams($stmt, $data);
		$stmt->bindParam(':answerId', $answerId, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->rowCount() == 1 ? $this->findAnswer($answerId) : null;
	}
	
	public function deleteAnswer($answerId){
		$sql = "DELETE FROM {$this->getAnswerTableName()} WHERE answerId=:answerId";
		$stmt=$this->getConnection()->prepare($sql);
		$stmt->bindParam(':answerId', $answerId, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->rowCount();
		return ($result == NULL) ? 0 : $result;
	}
	
	public function deleteAnswersByPollId($pollId){
		$sql = "DELETE FROM {$this->getAnswerTableName()} WHERE pollId=:pollId";
		$stmt=$this->getConnection()->prepare($sql);
		$stmt->bindParam(':pollId', $pollId, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->rowCount();
		return ($result == NULL) ? 0 : $result;
	}
	
	private function getAnswerTableName(){
		return $this->tableName;
	}
}