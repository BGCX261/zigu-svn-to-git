<?php
require_once 'zigu/base/BaseDao.php';
require_once 'zigu/poll/dao/PollConnectionFactory.php';

class PollBaseDao extends BaseDao {
	
	/**
	 * @return PDO
	 */
	public function getConnection(){
		return PollConnectionFactory::getInstance()->getConnection();
	}
}