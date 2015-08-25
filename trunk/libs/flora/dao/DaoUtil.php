<?php

class DaoUtil
{
    static function implodeIntsForQuery(Array $items)
    {
        foreach ($items as $key => $item) {
            $items[$key] = intval($item) ? intval($item) : 0;
        }
        $items = implode(',', $items);
        return $items;
    }
}