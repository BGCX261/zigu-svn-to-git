<?php

require_once 'zigu/poll/dao/PollItemDao.php';
require_once 'zigu/poll/dao/PollBaseDao.php';

class PollItemDaoImpl extends PollBaseDao implements PollItemDao {
    
    private $tableName = 'zigu_pollitems';

    public function addItem(array $data) {
        $sql = $this->getInsertSql ( $this->getItemTableName (), array_keys ( $data ) );
        $stmt = $this->getConnection ()->prepare ( $sql );
        $this->bindParams ( $stmt, $data );
        $stmt->execute ();
        return $stmt->rowCount () == 1 ? $this->findItem ( $this->getConnection ()->lastInsertId () ) : null;
    }

    public function findItem($itemId) {
        $sql = "SELECT * FROM {$this->getItemTableName()} WHERE itemId=:itemId";
        $stmt = $this->getConnection ()->prepare ( $sql );
        $stmt->bindParam ( ':itemId', $itemId, PDO::PARAM_INT );
        $stmt->execute ();
        $result = $stmt->fetch ( PDO::FETCH_OBJ );
        return ($result) ? $result : NULL;
    }

    public function findItemsByPollId($pollId) {
        $sql = "SELECT * FROM {$this->getItemTableName()} WHERE pollId=:pollId";
        $stmt = $this->getConnection ()->prepare ( $sql );
        $stmt->bindParam ( ':pollId', $pollId, PDO::PARAM_INT );
        $stmt->execute ();
        $result = $stmt->fetchAll ( PDO::FETCH_OBJ );
        return ($result) ? $result : NULL;
    }

    public function findItemsByQuestionId($questionId) {
        $sql = "SELECT * FROM {$this->getItemTableName()} WHERE questionId=:questionId";
        $stmt = $this->getConnection ()->prepare ( $sql );
        $stmt->bindParam ( ':questionId', $questionId, PDO::PARAM_INT );
        $stmt->execute ();
        $result = $stmt->fetchAll ( PDO::FETCH_OBJ );
        return ($result) ? $result : NULL;
    }

    public function updateItem(array $data, $ItemId) {
        if (array_key_exists ( 'itemId', $data )) {
            unset ( $data ['itemId'] );
        }
        
        $sql = $this->getUpdateSql ( $this->getItemTableName (), array_keys ( $data ), 'itemId=:itemId' );
        $stmt = $this->getConnection ()->prepare ( $sql );
        $this->bindParams ( $stmt, $data );
        $stmt->bindParam ( ':itemId', $ItemId, PDO::PARAM_INT );
        $stmt->execute ();
        return $stmt->rowCount () == 1 ? $this->findItem ( $ItemId ) : null;
    }

    public function deleteItem($ItemId) {
        $sql = "DELETE FROM {$this->getItemTableName()} WHERE itemId=:itemId";
        $stmt = $this->getConnection ()->prepare ( $sql );
        $stmt->bindParam ( ':itemId', $ItemId, PDO::PARAM_INT );
        $stmt->execute ();
        return $stmt->rowCount ();
    }

    public function deleteItems($itemIds) {
        require_once 'flora/dao/DaoUtil.php';
        $itemIds = DaoUtil::implodeIntsForQuery($itemIds);
        $sql = "DELETE FROM {$this->getItemTableName()} WHERE itemId in ({$itemIds})";
        $stmt = $this->getConnection ()->prepare ( $sql );
        $stmt->execute ();
        return $stmt->rowCount ();
    }

    public function deleteItemsByPollId($pollId) {
        $sql = "DELETE FROM {$this->getItemTableName()} WHERE pollId=:pollId";
        $stmt = $this->getConnection ()->prepare ( $sql );
        $stmt->bindParam ( ':pollId', $pollId, PDO::PARAM_INT );
        $stmt->execute ();
        return intval($stmt->rowCount ());
    }

    private function getItemTableName() {
        return $this->tableName;
    }
}