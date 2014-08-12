<?php

require ('Assignment.php');
require ('StatusChange.php');

class HistoryManager
{
    protected $task_id;
    
    protected $dbAdapter;
    
    protected $assignees;
    
    public function __construct( $id, DbAdapter $dbAdapter)
    {
        $this->task_id = $id;
        $this->dbAdapter = $dbAdapter;
    }
    
    public function saveHistory($data)
    {
        if (Assignment::containsRequiredColumnsIn($data)) {
            $this->dbAdapter->insert(Assignment::getInsertData($data, $this->task_id));
        }
        if (StatusChange::containsRequiredColumnsIn($data)) {
            $this->dbAdapter->insert(StatusChange::getInsertData($data, $this->task_id));
        }
    }
    
    public function fetchHistory()
    {
        $data = ['task' => $this->dbAdapter->fetchTasks($this->task_id)];
        $history = [];
        foreach ($this->dbAdapter->fetchAssignments($this->task_id) as $assignmentData) {
            $history[] = $this->createAssignmentFromData($assignmentData);
        }
        foreach ($this->dbAdapter->fetchStatusChanges($this->task_id) as $statusData) {
            $history[] = $this->createStatusChangeFromData($statusData);
        }
        $data['history'] = $this->sortHistory($history);
        return $data;
    }
    
    private function getAssigneeNameById($assigneeId)
    {
        
        if ($this->assignees === null) {
            $this->assignees = $this->dbAdapter->fetchAllAssignees();
        }
        
        foreach ($this->assignees as $assignee) {
            if ($assignee['id'] == $assigneeId) {
                return $assignee['name'];
            }
        }
        
        return '';
    }
    
    private function sortHistory($historyEntries)
    {
        $sortArr = [];
        
        foreach ($historyEntries as $sortKey => $entry) {
            $sortArr[$sortKey] = $entry->getTime();
        }
        
        arsort($sortArr);
        
        $sortedArray = [];
        foreach ($sortArr as $key => $entry) {
            $sortedArray[] = $historyEntries[$key]->arrafy();
        }
        
        return $sortedArray;
    }
    
    private function createAssignmentFromData($data)
    {
        return new Assignment($this->getAssigneeNameById($data['assignee_id']), $data['time']);
    }
    
    private function createStatusChangeFromData($data)
    {
        return new StatusChange($data['status'], $data['time']);
    }
}