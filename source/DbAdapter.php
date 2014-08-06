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
}