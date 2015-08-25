<?php

require_once 'zigu/poll/dao/PollResultDao.php';
require_once 'zigu/poll/dao/PollBaseDao.php';

class PollResultDaoImpl extends PollBaseDao {
    private $tableName = 'zigu_pollresults';

    public function addResult(array $data) {
        $sql = $this->getInsertSql ( $this->getResultTableName (), array_keys ( $data ) );
        $stmt = $this->getConnection ()->prepare ( $sql );
        $this->bindParams ( $stmt, $data );
        $stmt->execute ();
        return $stmt->rowCount () == 1 ? $this->findResult ( $this->getConnection ()->lastInsertId () ) : null;
    }

    public function findResult($resultId) {
        $sql = "SELECT * FROM {$this->getResultTableName()} WHERE resultId=:resultId";
        $stmt = $this->getConnection ()->prepare ( $sql );
        $stmt->bindParam ( ':resultId', $resultId, PDO::PARAM_INT );
        $stmt->execute ();
        $found = $stmt->fetch ( PDO::FETCH_OBJ );
        return empty ( $found ) ? null : $found;
    }

    public function findResultsByItemId($itemId) {
        if (! $itemId)
            return NULL;
        $sql = "SELECT * FROM {$this->getResultTableName()} WHERE itemId=:itemId";
        $stmt = $this->getConnection ()->prepare ( $sql );
        $stmt->bindParam ( ':itemId', $itemId, PDO::PARAM_INT );
        $stmt->execute ();
        $found = $stmt->fetch ( PDO::FETCH_OBJ );
        return empty ( $found ) ? null : $found;
    }
	
    //@todo 不要删除
//    public function findResultsByItemId($itemId) {
//        if (! $itemId)
//            return NULL;
//        $sql = "SELECT * FROM {$this->getResultTableName()} WHERE itemId=:itemId";
//        $stmt = $this->getConnection ()->prepare ( $sql );
//        $stmt->bindParam ( ':itemId', $itemId, PDO::PARAM_INT );
//        $stmt->execute ();
//        $found = $stmt->fetchAll ( PDO::FETCH_OBJ );
//        return empty ( $found ) ? null : $found;
//    }

    public function findResultsByPollId($pollId) {
        if (! $pollId)
            return NULL;
        $sql = "SELECT * FROM {$this->getResultTableName()} WHERE pollId=:pollId";
        $stmt = $this->getConnection ()->prepare ( $sql );
        $stmt->bindParam ( ':pollId', $pollId, PDO::PARAM_INT );
        $stmt->execute ();
        $found = $stmt->fetchAll ( PDO::FETCH_OBJ );
        return empty ( $found ) ? null : $found;
    }

    public function updateResult($data, $resultId) {
        if (array_key_exists ( 'resultId', $data )) {
            unset ( $data ['resultId'] );
        }
        $sql = $this->getUpdateSql ( $this->getResultTableName (), array_keys ( $data ), 'resultId=:resultId' );
        $stmt = $this->getConnection ()->prepare ( $sql );
        $stmt->bindParam ( ':pollCounts', $data['pollCounts'], PDO::PARAM_INT );
        $stmt->bindParam ( ':resultId', $resultId, PDO::PARAM_INT );
        $stmt->execute ();
        return $stmt->rowCount () == 1 ? $this->findResult ( $resultId ) : null;
    }
    
    public function updateResultCount($pollCounts,$itemId){
    	if(!$itemId){
    		return 0;
    	}
    	$sql = "UPDATE {$this->getResultTableName()} SET pollCounts = pollCounts + :pollCounts WHERE itemId=:itemId";
        $stmt = $this->getConnection ()->prepare ( $sql );
        $stmt->bindParam ( ':pollCounts', $pollCounts, PDO::PARAM_INT );
        $stmt->bindParam ( ':itemId', $itemId, PDO::PARAM_INT );
        $stmt->execute ();
        return $stmt->rowCount ();
    }

    public function deleteResult($resultId) {
        if (! $resultId)
            return 0;
        $sql = "DELETE FROM {$this->getResultTableName()} WHERE resultId=:resultId";
        $stmt = $this->getConnection ()->prepare ( $sql );
        $stmt->bindParam ( ':resultId', $resultId, PDO::PARAM_INT );
        $stmt->execute ();
        $result = $stmt->rowCount ();
        return ($result == NULL) ? 0 : $result;
    }

    public function deleteResultsByPollId($pollId) {
        if (! $pollId)
            return 0;
        $sql = "DELETE FROM {$this->getResultTableName()} WHERE pollId=:pollId";
        $stmt = $this->getConnection ()->prepare ( $sql );
        $stmt->bindParam ( ':pollId', $pollId, PDO::PARAM_INT );
        $stmt->execute ();
        $result = $stmt->rowCount ();
        return ($result == NULL) ? 0 : $result;
    }

    private function getResultTableName() {
        return $this->tableName;
    }
}