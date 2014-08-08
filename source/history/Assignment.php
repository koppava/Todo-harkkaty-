<?php
require_once ('AbstractHistoryRecord.php');

class Assignment extends AbstractHistoryRecord
{
    protected static function listRequiredColumns()
    {
        return ['assignee_id'];
    }
    
    protected static function getEntityName()
    {
        return 'assignment';
    }
}