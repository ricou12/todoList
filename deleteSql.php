<?php
require_once('jsonEncode.php');
// IMPORTE ET INSTANCIE LA CLASSE GESTION SQL
require_once('Class_SqlComponent.class.php');
$sqlCommande = new MyComponentsSql();

 /* Il s'agit d'un flux en lecture seule qui nous permet de lire les données brutes du corps de la requête?quel que soit le type de contenu.*/
$json = file_get_contents('php://input');

/* Cette fonction prend une chaîne JSON et la convertit en une variable PHP qui peut être un tableau ou un objet.*/
$data = json_decode($json);

// traitement de donnees reçues et envoie une reponse au serveur.
if(isset($data)) {
    // CONNEXION A LA BASE DE DONNEE
    $connect = $sqlCommande->connectDataBase('todoList');
    // ENREGISTRE LES DONNEES DANS LA DATABASE
    $ResponseOfRequest = $sqlCommande->deleteEntry($data->table,$data->id);
    send_json([
       "success" => $ResponseOfRequest
       ]);
} else {
    send_json([
      "success" => "Aucune donnée reçue !"
      ]);
}