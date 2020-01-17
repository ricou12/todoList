<?php
require_once('jsonEncode.php');
// IMPORTE ET INSTANCIE LA CLASSE DE GESTION DE LA DATABASE
require_once('Class_SqlComponent.class.php');
$sqlCommande = new MyComponentsSql();

// CONNEXION A LA BASE DE DONNEE
$connect = $sqlCommande->connectDataBase('todoList');
// RECUPERE TOUS LES ENREGISTREMENT by ID USER
$dataOfRequest = $sqlCommande->getDataBase('1');
send_json($dataOfRequest);
