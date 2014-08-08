<?php

require ('Assignment.php');
require ('StatusChange.php');

class HistoryRecorder
{
    protected $data;
    
    protected $task_id;
    
    protected $historyRecords;
    
    public function __construct($data, $id)
    {
        $this->data = $data;
        $this->task_id = $id;
    }
    
    public function saveHistory(DbAdapter $dbAdapter)
    {
        if (Assignment::containsRequiredColumnsIn($this->data)) {
            $dbAdapter->insert(Assignment::getInsertData($this->data, $this->task_id));
        }
        if (StatusChange::containsRequiredColumnsIn($this->data)) {
            $dbAdapter->insert(StatusChange::getInsertData($this->data, $this->task_id));
        }
    }
    
    
}