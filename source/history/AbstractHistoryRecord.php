<?php

abstract class AbstractHistoryRecord
{   
    protected $time;
    
    public function __construct($time)
    {
        $this->time = $time;
    }
    
    public function getTime()
    {
        return $this->time;
    }
    
    abstract static protected function listRequiredColumns();
    
    abstract static protected function getEntityName();
    
    abstract protected function arrafyRecordSpecificData();

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
    
    final public function arrafy()
    {
        return [$this->getEntityName() => 
            array_merge(
                ['time' => $this->timeToLapse()],
                $this->arrafyRecordSpecificData()
            )
            ];
    }
    
    final protected function timeToLapse()
    {
        $interval = time() - strtotime($this->time);
        
        $lapseMap = [
            0 => ['now', 0],
            10 => ['second(s)', 1],
            60 => ['minute(s)', 60],
            60*60 => ['hour(s)', 60*60],
            60*60*24 => ['day(s)', 60*60*24],
            60*60*24*7 => ['week(s)', 60*60*24*7],
            60*60*24*7*31 => ['month(s)', 60*60*24*7*31],
            60*60*24*7*365 => ['year(s)', 60*60*24*7*365]
        ];
        foreach (array_reverse($lapseMap, true) as $unit => $lapse) {
            if ($interval >= $unit) {
                return ceil($interval / $lapse[1]) . ' ' . $lapse[0] . ($unit !== 0? ' ago' : '');
            }
        }
    }
}