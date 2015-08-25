<?php
require_once 'flora/utils/BaseDataGenerator.php';

class ItemDataGenerator extends BaseDataGenerator {
    
    protected $table = 'zigu_pollitems';
    protected $primary_key = 'itemId';
    protected $rows = array (
        array (
            'itemId' => 1, 
            'pollId' => 1, 
            'questionId' => 1, 
            'name' => '', 
            'questionType' => 1, 
            'title' => 'item_1', 
            'initCount' => 10
        ), 
        array (
            'itemId' => 2, 
            'pollId' => 1, 
            'questionId' => 1, 
            'name' => '', 
            'questionType' => 1, 
            'title' => 'item_2', 
            'initCount' => 10
        ), 
        array (
            'itemId' => 3, 
            'pollId' => 1, 
            'questionId' => 1, 
            'name' => '', 
            'questionType' => 1, 
            'title' => 'item_3', 
            'initCount' => 10
        ), 
        array (
            'itemId' => 4, 
            'pollId' => 1, 
            'questionId' => 1, 
            'name' => '', 
            'questionType' => 1, 
            'title' => 'item_4', 
            'initCount' => 10
        ), 
        array (
            'itemId' => 5, 
            'pollId' => 1, 
            'questionId' => 2, 
            'name' => '', 
            'questionType' => 1, 
            'title' => 'item_5', 
            'initCount' => 10
        ), 
        array (
            'itemId' => 6, 
            'pollId' => 1, 
            'questionId' => 2, 
            'name' => '', 
            'questionType' => 1, 
            'title' => 'item_6', 
            'initCount' => 10
        ), 
        array (
            'itemId' => 7, 
            'pollId' => 1, 
            'questionId' => 2, 
            'name' => '', 
            'questionType' => 1, 
            'title' => 'item_7', 
            'initCount' => 10
        ), 
        array (
            'itemId' => 8, 
            'pollId' => 1, 
            'questionId' => 3, 
            'name' => '', 
            'questionType' => 1, 
            'title' => 'item_8', 
            'initCount' => 10
        ), 
        array (
            'itemId' => 9, 
            'pollId' => 1, 
            'questionId' => 4, 
            'name' => '', 
            'questionType' => 1, 
            'title' => 'item_9', 
            'initCount' => 10
        )
    );
}