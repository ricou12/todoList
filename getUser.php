<?php
// je recupere email + password
// verifie dans la base de si user existe
// renvoi l'id
//cree une session
require_once('openSession.php');
require_once('jsonEncode.php');
require_once('Class_SqlComponent.class.php');
$sqlCommande = new MyComponentsSql();

 /* Il s'agit d'un flux en lecture seule qui nous permet de lire les données brutes du corps de la requête?
 quel que soit le type de contenu.*/
$json = file_get_contents('php://input');

/* Cette fonction converti une chaîne JSON en une variable PHP de type tableau.*/
$data = json_decode($json);

// traitement de donnees reçues et envoie une reponse au serveur.
if(isset($data)) {
    // CONNEXION A LA BASE DE DONNEE
    $connect = $sqlCommande->connectDataBase('todoList');
    // VERIFIE SI UN COMPTE EXISTE ET RENVOI L'ID
    $stateOfRequest = $sqlCommande->getUserAndListTodo($data->email);
    // SI USER A UN COMPTE
    if ($stateOfRequest){
       // JOINTURE TABLE USER ET TODOLIST OU EMAIL DU CHAMP INPUT CORRESPOND A UN ELEMENT DE LA TABLE USER.
        if (password_verify($data->password, $stateOfRequest['passworduser'])) {
            // RECUPERE TOUT LES CHAMPS
            newCreateSession($stateOfRequest['iduser']);
            // ENVOIE AU CLIENT
            send_json([
            "success" => true,
            "iduser" => $stateOfRequest['iduser'],
            "nomuser" => $stateOfRequest['nomuser'],
            "titretodo" => $stateOfRequest['titretodo'],
            "contenutodo" => $stateOfRequest['contenutodo'],
            "actiftodo" => $stateOfRequest['actiftodo'],
            "datetodo" => $stateOfRequest['datetodo']
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