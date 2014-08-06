<?php
require ('Service.php');


class Controller
{
    /**
     * @var Service
     */
    protected $service;
    
    public function __construct()
    {
        $this->service = new Service();
    }
    
    public function handleRequest($request)
    {
        
        $response = array();
        if ($request['REQUEST_METHOD'] == 'GET') {
            $response = $this->service->getAll();
        }
        if ($request['REQUEST_METHOD'] == 'POST') {
            $this->service->persistRequestData($_POST);
            $response = $this->service->getAll();
        }
        
        echo json_encode($response);
    }
}