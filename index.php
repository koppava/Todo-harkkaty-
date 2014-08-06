<?php
require('source/Controller.php');

$controller = new Controller();
$controller->handleRequest($_SERVER);