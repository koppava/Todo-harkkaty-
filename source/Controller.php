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
            $data = $this->parseQueryData($_SERVER['QUERY_STRING']);
            if (isset($data['task'])) {
                $response = $this->service->getTask($data['task']);
            }
            else {
                $response = $this->service->getAllTasks();
            }
        }
        if ($request['REQUEST_METHOD'] == 'POST') {
            $this->service->persistRequestData($_POST);
        }
        if ($request['REQUEST_METHOD'] == 'PUT') {
            $this->service->saveData($this->parseQueryData(file_get_contents("php://input")));
        }
        
        echo json_encode($response);
    }
    
    private function parseQueryData($input)
    {
        $dataArr = [];
        $fields = explode('&', $input);
        foreach ($fields as $field) {
            $data = explode('=', $field);
            if (count($data) == 2) {
                $dataArr[$data[0]] = $data[1];
            }
        }
        return $dataArr;
    }
}