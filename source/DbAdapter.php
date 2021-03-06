<?php

class DbAdapter extends PDO
{
    public function __construct()
    {
        $dsn = 'mysql:host=localhost;dbname=todo';
        require('Config.php');

        $username = $config['username'];
        $password = $config['password'];
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );

        parent::__construct($dsn, $username, $password, $options);
    }
    
    private function getTableName(&$data)
    {
        $tableName = $data['entity'];
        unset($data['entity']);
        return $tableName;
    }
    
    private function prepareInsertSql(&$data)
    {
        $sql = 'INSERT INTO ' . $this->getTableName($data) . ' (';
        
        $columns = array_keys($data);
        foreach ($columns as $column) {
            if ($columns[0] != $column) {
                $sql .= ',';
            }
            $sql .= $column;
        }
        
        $sql .= ') VALUES (';
        
        foreach ($columns as $column) {
            if ($columns[0] != $column) {
                $sql .= ',';
            }
            $sql .= ':' . $column;
        }
        
        $sql .= ');';
        
        return $sql;
    }
    
    private function prepareUpdateSql(&$data)
    {
        $sql = 'UPDATE ' . $this->getTableName($data) . ' SET ';
        
        $columns = array_keys($data);
        foreach ($columns as $column) {
            if ($columns[0] != $column) {
                $sql .= ',';
            }
            $sql .= $column .'=:'. $column;
        }
        
        $sql .= ' WHERE id=:id;';
        return $sql;
    }
    
    private function bindData($statement, $data)
    {
        foreach (array_keys($data) as $column) {
            // Bind params takes reference to var, do we must use the array
            $statement->bindParam(':' . $column, $data[$column]);
        }
        
        return $statement;
    }
    
    public function insert($data)
    {
        $statement = $this->prepare($this->prepareInsertSql($data));
        
        $this->bindData($statement, $data);
        
        if ($statement->execute() === false) {
            var_dump($statement->errorInfo());
        }
    }
    
    public function update($id, $data)
    {
        $statement = $this->prepare($this->prepareUpdateSql($data));
        $statement->bindParam(':id', $id);
        $this->bindData($statement, $data);
        
        if ($statement->execute() === false) {
            var_dump($statement->errorInfo());
        }
    }
    
    public function fetchTasks($id = null)
    {
        $statement = $this->prepare("SELECT * FROM task;");
        if ($id) {
            $statement = $this->prepare("SELECT * FROM task WHERE id=:id");
            $statement->bindParam(':id', $id);
        }
        $statement->execute();
        return $statement->fetchAll();
    }
    
    public function fetchAllAssignees()
    {
        $statement = $this->prepare("SELECT * FROM assignee;");
        $statement->execute();
        return $statement->fetchAll();
    }
    
    public function fetchAssignments($taskId)
    {
        $statement = $this->prepare("SELECT * FROM assignment WHERE task_id=:task_id");
        $statement->bindParam(':task_id', $taskId);
        $statement->execute();
        return $statement->fetchAll();
    }
    
    public function fetchStatusChanges($taskId)
    {
        $statement = $this->prepare("SELECT * FROM status_change WHERE task_id=:task_id");
        $statement->bindParam(':task_id', $taskId);
        $statement->execute();
        return $statement->fetchAll();
    }
}