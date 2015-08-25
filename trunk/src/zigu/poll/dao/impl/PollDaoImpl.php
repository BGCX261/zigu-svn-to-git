<?php

require_once 'zigu/poll/dao/PollDao.php';
require_once 'zigu/poll/dao/PollBaseDao.php';

class PollDaoImpl extends PollBaseDao implements PollDao {
	private $tablename = 'zigu_polls';

	public function addPoll(array $data){
		$sql = $this->getInsertSql($this->getPollTableName(), array_keys($data));
		$stmt = $this->getConnection()->prepare($sql);
		$this->bindParams($stmt, $data);
		$stmt->execute();
		return $stmt->rowCount() == 1 ? $this->findPoll($this->getConnection()->lastInsertId()) : null;
	}

	public function findPoll($pollId){
		$sql = "SELECT * FROM {$this->getPollTableName()} WHERE pollId=:pollId";
		$stmt= $this->getConnection()->prepare($sql);
		$stmt->bindParam(':pollId',$pollId, PDO::PARAM_INT);
		$stmt->execute();
		$found = $stmt->fetch(PDO::FETCH_OBJ);
		return empty($found) ? null : $found;
	}

	public function findPollsWithCondition($start, $limit, $orderBy) {
		//TODO: filter orderBy
		$sql = "SELECT * FFROM {{$this->getPollTableName()}} ORDER BY {$orderBy} LIMIT :start, :limit";
		$stmt= $this->getConnection()->prepare($sql);
		$stmt->bindParam(':start',$start, PDO::PARAM_INT);
		$stmt->bindParam(':limit',$limit, PDO::PARAM_INT);
		$stmt->execute();
		$found = $stmt->fetchAll(PDO::FETCH_OBJ);
		return empty($found) ? null : $found;
	}

	public function updatePoll(array $data, $pollId ){
		if (array_key_exists('pollId', $data)) {
			unset($data['pollId']);
		}
		$sql = $this->getUpdateSql($this->getPollTableName(), array_keys($data), 'pollId=:pollId');
		$stmt=$this->getConnection()->prepare($sql);
		$this->bindParams($stmt, $data);
		$stmt->bindParam(':pollId', $pollId, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->rowCount() == 1 ? $this->findPoll($pollId) : null;
	}

	public function deletePoll($pollId){
		$sql = "DELETE FROM {$this->getPollTableName()} WHERE pollId=:pollId";
		$stmt= $this->getConnection()->prepare($sql);
		$stmt->bindParam(':pollId', $pollId, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->rowCount();
	}

	public function deletePolls(array $pollIds){
		require_once 'flora/dao/DaoUtil.php';
		$pollIds = Daoutil::implodeIntsForQuery($pollIds);
		$sql = "DELETE FROM {$this->getPollTableName()} WHERE pollId in ({$pollIds})";
		$stmt=$this->getConnection()->prepare($sql);
		$stmt->execute();
		return $stmt->rowCount();
	}

	public function findPolls($offset=0, $limit=30){
		$sql = "SELECT * FROM {$this->getPollTableName()} order by createTime DESC LIMIT :offset,:limit";
		$stmt= $this->getConnection()->prepare($sql);
		$stmt->bindParam(':offset',$offset, PDO::PARAM_INT);
		$stmt->bindParam(':limit',$limit, PDO::PARAM_INT);
		$stmt->execute();
		$found = $stmt->fetchAll(PDO::FETCH_OBJ);
		return empty($found) ? null : $found;
	}
	
	public function searchPollsByTitle($pollTitle,$offset=0, $limit=30) {
		$sql = "SELECT * FROM {$this->getPollTableName()} WHERE  pollTitle LIKE :pollTitle ORDER BY createTime DESC LIMIT :offset, :limit";
		$stmt= $this->getConnection()->prepare($sql);
		$stmt->bindValue(':pollTitle', '%'.$pollTitle.'%');
		$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
		$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchALL(PDO::FETCH_OBJ);
	}
	
	public function searchPollsByAuthor($createUser,$offset=0, $limit=30) {
		$sql = "SELECT * FROM {$this->getPollTableName()} WHERE  createUser LIKE :createUser ORDER BY createTime DESC LIMIT :offset, :limit";
		$stmt= $this->getConnection()->prepare($sql);
		$stmt->bindValue(':createUser', '%'.$createUser.'%');
		$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
		$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchALL(PDO::FETCH_OBJ);
	}

	private function getPollTableName(){
		return $this->tablename;
	}
}