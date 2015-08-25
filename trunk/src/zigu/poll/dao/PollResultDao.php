<?php
interface PollResultsDao{
	
	public function addResult(array $data);
	
	public function findResult($resultId);
	
	public function findResultsByItemId($itemId);
	
	public function findResultsByPollId($pollId);
	
	public function updateResult($data, $resultId);
	
	public function deleteResult($resultId);
	
	public function deleteResultsByPollId($pollId);
}