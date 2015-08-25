<?php
interface PollQuestionDao {
	public function addQuestion(array $data);

	public function findQuestion($questionId);

	public function findQuestionsByPollId($pollId);

	public function updateQuestion(array $data, $questionId);
	
	public function deleteQuestion($questionId);
	
	public function deleteQuestionsByPollId($pollId);
}
