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

    // AJOUTE UNE NOUVELLE ENTREE DANS LA BASE (POST)
    public function updateDatabase($titre,$note,$user){
        try{
            $query = $this->_dataBase->prepare('INSERT INTO blocnote(titre, note, user) VALUES(:titre, :note, :user)');
                $query->execute(array(
                'titre' => $titre,
                'note' => $note,
                'user' => intval($user),
	        ));
            // $query->closeCursor(); 
            return true;
        } catch (Exception $e) {
            return false;
        }  
    }

    function getDataBase($user){
        // Récupère les infos dans la base de donnée.
        $query = $this->_dataBase->prepare('SELECT titre, note FROM blocnote WHERE user = :user');
        $query->bindParam(':user', intval($user));
        $query->execute();
        $result = $query->fetch();
        $query->closeCursor();
        return $result;
        
    }

}

?>