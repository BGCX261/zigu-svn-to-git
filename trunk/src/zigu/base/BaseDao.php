<?php

class BaseDao {
    
    protected function getInsertSql($tableName, $fields) {
        foreach ($fields as $field) {
            $insertFields[] = '`' . $field . '`';
            $insertValues[] = ':' . $field;
        }
        $insertFieldsString = implode(',', $insertFields);
        $insertValuesString = implode(',', $insertValues);
        return "INSERT INTO {$tableName} ({$insertFieldsString}) VALUES ($insertValuesString);";
    }
    
    protected function getUpdateSql($tableName, $fields, $where) {
        foreach ($fields as $field) {
            $toUpdateFields[] = sprintf('`%s`=:%s', $field,$field);
        }
        $toUpdateFields= implode(',', $toUpdateFields);
        return "UPDATE {$tableName} SET {$toUpdateFields} WHERE {$where};";
    }
    
    protected function bindParams(&$stmt, &$data) {
        foreach ($data as $key => &$value) {
            $stmt->bindParam(':'. $key, $value);
            unset($value);
        }
    }
}