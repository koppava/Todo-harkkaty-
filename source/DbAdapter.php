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
    
    public function insertTodo($data)
    {
        $statement = $this->prepare('INSERT INTO task (task_name, assignee, deadline, done)'
                . ' VALUES (:task_name, :assignee, :deadline, :done);');
        $statement->bindParam(':task_name', $data['task_name']);
        $statement->bindParam(':assignee', $data['assignee']);
        $statement->bindParam(':deadline', $data['deadline']->format('Y-m-d'));
        $statement->bindParam(':done', $data['done']);
        $statement->execute();
    }
    
    public function fetchAll()
    {
        $statement = $this->prepare("SELECT * FROM task;");
        $statement->execute();
        return $statement->fetchAll();
    }
}