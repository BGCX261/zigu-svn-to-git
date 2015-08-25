<?php

require_once 'zigu/poll/dao/PollQuestionDao.php';
require_once 'zigu/poll/dao/PollBaseDao.php';

class PollQuestionDaoImpl extends PollBaseDao {
    
    private $tableName = 'zigu_pollquestions';

    public function addQuestion(array $data) {
        $sql = $this->getInsertSql ( $this->getQuestionTableName (), array_keys ( $data ) );
        $stmt = $this->getConnection ()->prepare ( $sql );
        $this->bindParams ( $stmt, $data );
        $stmt->execute ();
        return $stmt->rowCount () == 1 ? $this->findQuestion ( $this->getConnection ()->lastInsertId () ) : null;
    }

    public function findQuestion($questionId) {
        $sql = "SELECT * FROM {$this->getQuestionTableName()} WHERE questionId=:questionId";
        $stmt = $this->getConnection ()->prepare ( $sql );
        $stmt->bindParam ( 'questionId', $questionId, PDO::PARAM_INT );
        $stmt->execute ();
        $found = $stmt->fetch ( PDO::FETCH_OBJ );
        return empty ( $found ) ? null : $found;
    }

    public function findQuestionsByPollId($pollId) {
        $sql = "SELECT * FROM {$this->getQuestionTableName()} WHERE pollId=:pollId";
        $stmt = $this->getConnection ()->prepare ( $sql );
        $stmt->bindParam ( 'pollId', $pollId, PDO::PARAM_INT );
        $stmt->execute ();
        $found = $stmt->fetchAll ( PDO::FETCH_OBJ );
        return empty ( $found ) ? null : $found;
    }

    public function updateQuestion(array $data, $questionId) {
        if (array_key_exists ( 'questionId', $data )) {
            unset ( $data ['questionId'] );
        }
        $sql = $this->getUpdateSql ( $this->getQuestionTableName (), array_keys ( $data ), 'questionId=:questionId' );
        $stmt = $this->getConnection ()->prepare ( $sql );
        $this->bindParams ( $stmt, $data );
        $stmt->bindParam ( ':questionId', $questionId, PDO::PARAM_INT );
        $stmt->execute ();
        return $stmt->rowCount () == 1 ? $this->findQuestion ( $questionId ) : null;
    }

    public function deleteQuestion($questionId) {
        $sql = "DELETE FROM {$this->getQuestionTableName()} WHERE questionId=:questionId";
        $stmt = $this->getConnection ()->prepare ( $sql );
        $stmt->bindParam ( ':questionId', $questionId, PDO::PARAM_INT );
        $stmt->execute ();
        return $stmt->rowCount ();
    }
    
    public function deleteQuestions($questionIds) {
    	require_once 'flora/dao/DaoUtil.php';
		$questionIds = Daoutil::implodeIntsForQuery($questionIds);
        $sql = "DELETE FROM {$this->getQuestionTableName()} WHERE questionId IN ({$questionIds})";
        $stmt = $this->getConnection ()->prepare ( $sql );
        $stmt->execute ();
        return $stmt->rowCount ();
    }

    public function deleteQuestionsByPollId($pollId) {
        $sql = "DELETE FROM {$this->getQuestionTableName()} WHERE pollId=:pollId";
        $stmt = $this->getConnection ()->prepare ( $sql );
        $stmt->bindParam ( ':pollId', $pollId, PDO::PARAM_INT );
        $stmt->execute ();
        return $stmt->rowCount ();
    }
    
    private function getQuestionTableName() {
        return $this->tableName;
    }
}