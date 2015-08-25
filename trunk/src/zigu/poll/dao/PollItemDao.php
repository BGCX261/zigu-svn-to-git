<?php

interface PollItemDao {
	public function addItem(array $data);
	public function findItem($itemId);
	public function findItemsByPollId($pollId);
	public function findItemsByQuestionId($questionId);
	public function updateItem(array $data, $ItemId);
	public function deleteItem($ItemId);
	public function deleteItems($itemIds);
	public function deleteItemsByPollId($pollId);
}
