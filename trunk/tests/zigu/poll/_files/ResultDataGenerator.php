<?php
require_once 'flora/utils/BaseDataGenerator.php';
class ResultDataGenerator extends BaseDataGenerator {
    protected $table = 'zigu_pollresults';
    protected $primary_key = 'resultId';
    protected $rows = array (
        array (
            'resultId' => 1, 
            'pollId' => 1, 
            'questionId' => 1, 
            'itemId' => 1, 
            'pollCounts' => 10
        ), 
        array (
            'resultId' => 2, 
            'pollId' => 1, 
            'questionId' => 1, 
            'itemId' => 2, 
            'pollCounts' => 10
        ), 
        array (
            'resultId' => 3, 
            'pollId' => 1, 
            'questionId' => 2, 
            'itemId' => 3, 
            'pollCounts' => 10
        ), 
        array (
            'resultId' => 4, 
            'pollId' => 1, 
            'questionId' => 3, 
            'itemId' => 4, 
            'pollCounts' => 10
        ), 
        array (
            'resultId' => 5, 
            'pollId' => 1, 
            'questionId' => 4, 
            'itemId' => 5, 
            'pollCounts' => 10
        ), 
        array (
            'resultId' => 6, 
            'pollId' => 1, 
            'questionId' => 5, 
            'itemId' => 6, 
            'pollCounts' => 10
        ), 
        array (
            'resultId' => 7, 
            'pollId' => 1, 
            'questionId' => 6, 
            'itemId' => 7, 
            'pollCounts' => 10
        ), 
        array (
            'resultId' => 8, 
            'pollId' => 1, 
            'questionId' => 7, 
            'itemId' => 8, 
            'pollCounts' => 10
        ), 
        array (
            'resultId' => 9, 
            'pollId' => 1, 
            'questionId' => 8, 
            'itemId' => 9, 
            'pollCounts' => 10
        )
    );

}