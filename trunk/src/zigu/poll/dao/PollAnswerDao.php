<?php
interface PollAnswerDao{
	
	public function addAnswer(array $data);

	public function findAnswer($answerId);

	public function findAnswersByPollId($pollId);

	public function findAnswersByItemId($itemId);
	
	public function updateAnswer(array $data, $answerId);
	
	public function deleteAnswer($answerId);
	
	public function deleteAnswersByPollId($pollId);
	
}
