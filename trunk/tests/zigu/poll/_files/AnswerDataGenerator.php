<?php
require_once 'flora/utils/BaseDataGenerator.php';
class AnswerDataGenerator extends BaseDataGenerator {
    
    protected $table = 'zigu_pollanswers';
    protected $primary_key = 'answerId';
    protected $rows = array (
        array (
            'answerId' => 1, 
            'pollId' => 1, 
            'questionId' => 1, 
            'itemId' => 1, 
            'answer' => 'answer_1', 
            'voteIp' => '192.168.0.1'
        ), 
        array (
            'answerId' => 2, 
            'pollId' => 1, 
            'questionId' => 1, 
            'itemId' => 2, 
            'answer' => 'answer_2', 
            'voteIp' => '192.168.0.1'
        ), 
        array (
            'answerId' => 3, 
            'pollId' => 1, 
            'questionId' => 2, 
            'itemId' => 3, 
            'answer' => 'answer_3', 
            'voteIp' => '192.168.0.1'
        ), 
        array (
            'answerId' => 4, 
            'pollId' => 1, 
            'questionId' => 2, 
            'itemId' => 4, 
            'answer' => 'answer_4', 
            'voteIp' => '192.168.0.1'
        ), 
        array (
            'answerId' => 5, 
            'pollId' => 1, 
            'questionId' => 2, 
            'itemId' => 5, 
            'answer' => 'answer_5', 
            'voteIp' => '192.168.0.1'
        ), 
        array (
            'answerId' => 6, 
            'pollId' => 1, 
            'questionId' => 2, 
            'itemId' => 6, 
            'answer' => 'answer_6', 
            'voteIp' => '192.168.0.1'
        ), 
        array (
            'answerId' => 7, 
            'pollId' => 1, 
            'questionId' => 3, 
            'itemId' => 7, 
            'answer' => 'answer_7', 
            'voteIp' => '192.168.0.1'
        ), 
        array (
            'answerId' => 8, 
            'pollId' => 1, 
            'questionId' => 3, 
            'itemId' => 8, 
            'answer' => 'answer_8', 
            'voteIp' => '192.168.0.1'
        ), 
        array (
            'answerId' => 9, 
            'pollId' => 1, 
            'questionId' => 3, 
            'itemId' => 9, 
            'answer' => 'answer_9', 
            'voteIp' => '192.168.0.1'
        )
    );
}