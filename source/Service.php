<?php

require ('DbAdapter.php');

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
        return ["tasks" => $this->dbAdapter->fetchAll()];
    }
    
    public function persistRequestData($data)
    {
        $data = $this->filterData($data);
        
        $this->dbAdapter->insertTask($data);
    }
    
    public function saveData($data)
    {
        $data = $this->filterData($data);
        
        $id = $data['id'];
        unset($data['id']);
        $this->dbAdapter->updateTask($id, $data);
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
}