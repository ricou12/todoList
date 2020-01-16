<?php
include_once('Class_SqlComponent.php');
$servResponse = new ComponentsSql();

// Takes raw data from the request
$json = file_get_contents('php://input');
// Converts it into a PHP object
$data = json_decode($json);

if(!isset($data->uploadListe)){
    header('Content-Type: application/json');
    
    echo json_encode($servResponse->getTodo());
}else{
    header('Content-Type: application/json');
    $response = [
        "success" => false,
    ];
    echo json_encode($response);
}
