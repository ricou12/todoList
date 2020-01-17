<?php

class MyComponentsSql {
    private $_dataBase;
    private $_nom;
    private $_note;
    

    // RECUPERE LA LES NOTES
    function getTodo(){
        return $this->getDataBase();
    }

    // CONNECTION A LA BASE DE DONNEES ET TRAITEMENT DES ERREURS
    public function connectDataBase($myDB){
       try{
            // CONNECTION A MYSQL
            $this->_dataBase = new PDO('mysql:host=localhost;dbname='.$myDB.';charset=utf8', 'root', '');
            return true;
        }
        catch (Exception $e){
	        // EN CAS D'ERREUR ON AFFICHE UN MESSAGE ET ON ARRETE TOUT
            die('Erreur : ' . $e->getMessage());
            return false;
        }
    }

    // AJOUTE UN NOUVEL UTILISATEUR DANS LA BASE (POST)
    public function addNewUser($user,$email,$password){
        // Si l'identifiant nom n'existe pas on procède à l'enregistrement.
        //On utilise alors notre fonction password_hash :
        $hash = password_hash($password1->get_value(), PASSWORD_DEFAULT);
        // Crée une nouvelle entrée avec les coordonnees d'inscription du nouvel utilisateur.
        $query = $bdd->prepare('INSERT INTO users(user,email,password) VALUES(:user, :email, :password);');
        $query->bindParam(':user', $nom->get_value());
        $query->bindParam(':email', $email->get_value());
        $query->bindParam(':password', $hash);
        $query->execute();
        $query->closeCursor();
    }

    // AJOUTE UNE NOUVELLE ENTREE DANS LA BASE (POST)
    public function updateDatabase($titre,$note,$user){
        try{
            $query = $this->_dataBase->prepare('INSERT INTO blocnote(titre, note, user) VALUES (:titre, :note, :user)');
                $query->execute(array(
                'titre' => $titre,
                'note' => $note,
                'user' => intval($user),
	        ));
            $query->closeCursor(); 
            return "Enregistrement réussi !";
        } catch (Exception $e) {
            return "Erreur lors de l'enregistrement, veuillez contacter l'administrateur !";
        }  
    }

    // RENVOI LA LISTE DE TOUT LES MEMO
    function getDataBase($user){
        try {
            $query = $this->_dataBase->prepare('SELECT id,titre,note FROM blocnote WHERE user=:user');
            $query->bindParam(':user', intval($user));
            $query->execute();
            $result = $query->fetchAll();
            $query->closeCursor();
            return $result;
        } catch (Exception $e) {
            return "Problèmes d'accès aux mémos, veuillez contacter l'administrateur !";
        } 
  
    }

    function getAllDataBase(){
        // Récupère les infos dans la base de donnée.
        try{
            $query = $this->_dataBase->prepare('SELECT id,titre,note FROM blocnote');
            $query->execute();
            $result = $query->fetchAll();
            $query->closeCursor();
            return $result;
        } catch (Exception $e) {
            return [false];
        } 
    }

    function deleteEntry($table,$id){
        try{
            $query = $this->_dataBase->prepare('DELETE FROM '.$table.' WHERE id=:id');
            $query->bindParam(':id', intval($id));
            $query->execute();
            return "Suppression réussie !";
        } catch (Exception $e) {
            return "Erreur lors de la suppression, veuillez contacter l'administrateur !";
        } 
    }
}

?>