<?php

abstract class BaseDataGenerator {
    protected $table = null;
    protected $rows = null;
    protected $primary_key = null;

    public function __construct() {
        if (empty ( $this->rows ) || empty ( $this->table )) {
            throw new Exception ( 'You must provide table(s) datasets' );
        }
    }

    public function getRow() {
        return $this->rows [array_rand($this->rows)];
    }
    
    public function getRowByFieldEqual($field, $value) {
        foreach ($this->rows as $row) {
            if ($row[$field] == $value) {
                return $row;
            }
        }
        return null;
    }
    
    public function getSomeRows() {
        $keys = array_rand($this->rows, rand(1, count($this->rows)));
        $keys = is_array($keys) ? $keys : array($keys);
        $rows = array();
        foreach ($keys as $key) {
            $rows[] = $this->rows[$key];
        }
        return $rows;
    }

    public function getAll() {
        return $this->rows;
    }

    public function getColumn($columnName, $rows= null) {
        if (empty($rows)) {
            $rows = $this->getAll ();
        }
        $result = array ();
        foreach ( $rows as $row ) {
            $result [] = $row [$columnName];
        }
        return $result;
    }
    
    public function getColumnPartial($columnName) {
        $rows = $this->getSomeRows();
        return $this->getColumn($columnName, $rows);
    }

    public function countByFieldEqual($field, $value) {
        $count = 0;
        foreach ( $this->getAll () as $row ) {
            if ($row [$field] == $value) {
                $count ++;
            }
        }
        return $count;
    }

    public function getTablename() {
        return $this->table;
    }
}
