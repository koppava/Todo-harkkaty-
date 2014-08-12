<?php
require_once ('AbstractHistoryRecord.php');

class StatusChange extends AbstractHistoryRecord
{
    protected $status;
    
    public function __construct($status, $time)
    {
        $this->status = $status;
        parent::__construct($time);
    }
    
    protected static function listRequiredColumns()
    {
        return ['status'];
    }
    
    protected static function getEntityName()
    {
        return 'status_change';
    }
    
    protected function arrafyRecordSpecificData()
    {
        return ['status' => $this->status];
    }
}