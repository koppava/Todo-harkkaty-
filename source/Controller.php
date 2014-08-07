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
        }
        if ($request['REQUEST_METHOD'] == 'PUT') {
            $this->service->saveData($this->parsePutData(file_get_contents("php://input")));
        }
        
        echo json_encode($response);
    }
    
    private function parsePutData($streamData)
    {
        $dataArr = [];
        $fields = explode('&', $streamData);
        foreach ($fields as $field) {
            $data = explode('=', $field);
            $dataArr[$data[0]] = $data[1];
        }
        return $dataArr;
    }
}