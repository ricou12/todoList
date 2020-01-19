<?php

class MyComponentsSql {

    private $_dataBase;

    // function __construct(){
    //     $this->connectDataBase('todoList');
    // }

    // CONNECTION A LA BASE DE DONNEES ET TRAITEMENT DES ERREURS
    public function connectDataBase($myDB){
       try {
            // CONNECTION A MYSQL
            $this->_dataBase = new PDO('mysql:host=localhost;dbname='.$myDB.';charset=utf8', 'root', '');
            return true;
        }
        catch (Exception $e) {
	        // EN CAS D'ERREUR ON AFFICHE UN MESSAGE ET ON ARRETE TOUT
            die('Erreur : ' . $e->getMessage());
            return false;
        }
    }

    // AJOUTE UN NOUVEL UTILISATEUR DANS LA BASE (POST)
    public function addNewUser($email,$password){
        try {
            $mdp =$this->hashPassword($password);
            $query = $this->_dataBase->prepare('INSERT INTO users (email,mdp) VALUES (:email, :mdp)');
            $query->bindParam(':email', $email);
            $query->bindParam(':mdp',$mdp);
            $query->execute();
            $query->closeCursor();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    // RECUPERE ID DU CLIENT (POST)
    public function getIdUsers($email){
        try {
            $query = $this->_dataBase->prepare('SELECT id,email,mdp FROM users WHERE email = :email');
			$query->bindParam(':email', $email);
			$query->execute();
			$result = $query->fetch();
			$query->closeCursor(); 
        return $result;
        } catch (Exception $e) {
        return false;
        }      
    }

    // AJOUTE UNE NOUVELLE ENTREE DANS LA BASE (POST)
    public function updateDatabase($titre,$note,$user){
        try{
            $query = $this->_dataBase->prepare('INSERT INTO blocnote (titre, note, user) VALUES (:titre, :note, :user)');
                $query->execute(array(
                'titre' => $titre,
                'note' => $note,
                'user' => intval($user),
	        ));
            $query->closeCursor(); 
            return true;
        } catch (Exception $e) {
            return false;
        }  
    }

    // RENVOI LA LISTE DE TOUT LES MEMOS PAR USER
    function getListTodo($user){
        try {
            $query = $this->_dataBase->prepare('SELECT id,titre,note FROM blocnote WHERE user=:user');
            $query->bindParam(':user', intval($user));
            $query->execute();
            $result = $query->fetchAll();
            $query->closeCursor();
            return $result;
        } catch (Exception $e) {
            return false;
        } 
    }

    // RENVOI LA LISTE DE TOUT LES MEMO
    function getAllDataBase(){
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

    // DELETE UNE ENTREE DANS LA TABLE MEMO
    public function deleteEntry($table,$id){
        try{
            $query = $this->_dataBase->prepare('DELETE FROM '.$table.' WHERE id=:id');
            $query->bindParam(':id', intval($id));
            $query->execute();
            return "Suppression réussie !";
        } catch (Exception $e) {
            return "Erreur lors de la suppression, veuillez contacter l'administrateur !";
        } 
    }

    public function hashPassword($nom){
        return password_hash($nom, PASSWORD_DEFAULT);
    }
}

?>