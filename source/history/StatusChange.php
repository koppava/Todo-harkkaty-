<?php
require_once ('AbstractHistoryRecord.php');

class StatusChange extends AbstractHistoryRecord
{
    protected static function listRequiredColumns()
    {
        return ['status'];
    }
    
    protected static function getEntityName()
    {
        return 'status_change';
    }
}