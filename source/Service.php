<?php

require ('DbAdapter.php');
require ('history/HistoryManager.php');

class Service
{
    /**
     *
     * @var DbAdapter
     */
    protected $dbAdapter;
    
    public function __construct()
    {
        $this->dbAdapter = new DbAdapter();
    }

    public function getAllTasks()
    {
        $data = ["tasks" => $this->dbAdapter->fetchTasks()];
        $data['assignees'] = $this->dbAdapter->fetchAllAssignees();
        return $data;
    }
    
    public function getTask($id)
    {
        $historyManager = new HistoryManager($id, $this->dbAdapter);
        return $historyManager->fetchHistory();
    }
    
    public function persistRequestData($data)
    {
        $data = $this->filterData($data);
        
        $this->dbAdapter->insert($data);
    }
    
    public function saveData($data)
    {
        $data = $this->filterData($data);
        
        $id = $data['id'];
        unset($data['id']);
        $this->dbAdapter->update($id, $data);
        
        $this->recordHistory($id, $data);
    }
    
    private function filterData($data)
    {
        foreach ($data as $key => $value) {
            if ($key == 'id' || $key == 'done') {
                $data[$key] = (int) $value;
            }
            if ($key == 'deadline') {
                $data[$key] = DateTime::createFromFormat('d-m-Y', $value)->format('Y-m-d');
            }
        }
        
        return $data;
    }
    
    private function recordHistory($id, $data)
    {
        $historyManager = new HistoryManager($id, $this->dbAdapter);
        $historyManager->saveHistory($data);
    }
}