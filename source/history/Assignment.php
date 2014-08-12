<?php
require_once ('AbstractHistoryRecord.php');

class Assignment extends AbstractHistoryRecord
{
    protected $name;
    
    public function __construct($name, $time)
    {
        $this->name = $name;
        parent::__construct($time);
    }
    
    protected static function listRequiredColumns()
    {
        return ['assignee_id'];
    }
    
    protected static function getEntityName()
    {
        return 'assignment';
    }
    
    protected function arrafyRecordSpecificData()
    {
        return ['name' => $this->name];
    }
}