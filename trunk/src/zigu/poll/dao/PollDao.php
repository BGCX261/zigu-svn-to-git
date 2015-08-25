<?php

/**
 * PollDao Interface
 */
interface PollDao {

    /**
     * Add a new poll record.
     *
     * @param array $data
     */
    public function addPoll(Array $data);

    /**
     * Find a poll record by pollId.
     *
     * @param int $pollId
     */
    public function findPoll($pollId);

    /**
     * Delete a poll record by pollId.
     *
     * @param int $pollId
     */
    public function deletePoll($pollId);

    /**
     * Delete poll records by pollIds.
     *
     * @param array $pollIds
     */
    public function deletePolls(Array $pollIds);

    /**
     * Update poll record by pollId.
     *
     * @param array $fields
     * @param int $pollId
     */
    public function updatePoll(Array $fields, $pollId);
}