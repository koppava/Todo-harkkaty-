<?php

require ('DbAdapter.php');
require ('history/HistoryRecorder.php');

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

    public function getAll()
    {
        $data = ["tasks" => $this->dbAdapter->fetchAllTasks()];
        $data['assignees'] = $this->dbAdapter->fetchAllAssignees();
        return $data;
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
        $historyRecorder = new HistoryRecorder($data, $id);
        $historyRecorder->saveHistory($this->dbAdapter);
    }
}