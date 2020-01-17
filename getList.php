<?php
require_once('jsonEncode.php');
// IMPORTE ET INSTANCIE LA CLASSE DE GESTION DE LA DATABASE
require_once('Class_SqlComponent.class.php');
$servResponse = new MyComponentsSql();

// CONNEXION A LA BASE DE DONNEE
$connect = $servResponse->connectDataBase('todoList');
// RECUPERE TOUS LES ENREGISTREMENT by ID USER
$stateOfRequest = $servResponse->getDataBase('1');
send_json($stateOfRequest);
    
// $stateOfRequest = $servResponse->getAllDataBase();