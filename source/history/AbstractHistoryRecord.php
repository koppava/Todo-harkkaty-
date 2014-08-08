<?php

abstract class AbstractHistoryRecord
{   
    abstract static protected function listRequiredColumns();
    
    abstract static protected function getEntityName();

    final static function containsRequiredColumnsIn($data)
    {
        foreach (static::listRequiredColumns() as $columnName) {
            if (!in_array($columnName, array_keys($data))) {
                return false;
            }
        }
        
        return true;
    }
    
    final static function getInsertData($data, $id)
    {
        $dataToBeStored = [];
        foreach ($data as $key => $value)
        {
            if (in_array($key, static::listRequiredColumns())) {
                $dataToBeStored[$key] = $value;
            }
        }
        
        return array_merge($dataToBeStored, ['task_id' => $id, 'entity' => static::getEntityName()]);
    }
}