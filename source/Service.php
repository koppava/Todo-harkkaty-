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
    
    public function persistRequestData($post)
    {
        $this->dbAdapter->insertTodo([
            'task_name' => $post['task_name'],
            'assignee' => $post['assignee'],
            'deadline' => DateTime::createFromFormat('d-m-Y', $post['deadline']),
            'done' => 0
        ]);
        
        return array_pop($this->getAll());
    }
}