<?php
// je recupere email + password
// verifie dans la base de si user existe
// renvoi l'i
//cree une session

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
    // VERIFIE SI UN COMPTE EXISTE ET RENVOI L'ID
    $stateOfRequest = $sqlCommande->getIdUsers($data->email);
    // SI USER A UN COMPTE
    if ($stateOfRequest){
       // VERIFIE LA VALIDITE DU COMPTE
        if (password_verify($data->password, $stateOfRequest['mdp'])) {
            // RECUPERE L'ID ET OUVRE UNE SESSION POUR LE COMPTE
            if(!session_status()) {
                session_start();
            } 
            $_SESSION['user'] = $stateOfRequest['id'];
            send_json([
            "success" => true,
            "session" => $stateOfRequest['id']
            ]);
        } else {
             send_json([
                "success" => false,
                "msg" => "Le mot de passe ne correspond pas !"
                ]);
        }
    } else {
        send_json([
        "success" => false,
        "msg" => "Vous n'êtes pas inscrit !"
        ]);
    }  
}