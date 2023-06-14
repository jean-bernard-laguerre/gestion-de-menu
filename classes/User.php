<?php

    include "Database.php";

    class User{

        public $id;
        public $login;
        public $pdo;

        function __construct($login)
        {
            $this->login = $login;
            $this->pdo = new Database();
        }

        public function register($password) {
            
            $req = $this->pdo->bdd->prepare( "SELECT * FROM user WHERE login = ?" );
            $req->execute( [$this->login] );
            $user = $req->fetch();
            
            // Ajout de l'utilisateur a la base de données si le formulaire est valide et l'utilisateur n'existe pas déja
            if(empty($user)) {
                $sql = "INSERT INTO user (login, password) VALUES (?,?)";
                $req = $this->pdo->bdd->prepare($sql);
                $req->execute( [$this->login, hash("sha256", $password)] );

                return True;
            }
            return false;
        }

        public function connect($password){

            $req = $this->pdo->bdd->prepare( "SELECT * FROM user WHERE login = ? AND password = ?" );
            $req->execute( [$this->login, hash("sha256", $password)] );
            $user = $req->fetch();
            
            if($user) {

                $this->id = $user["id"];

                $_SESSION["id"] = $user["id"];
                $_SESSION["login"] = $user["login"];
                
                return true;
            }
            return False;
        }
    }
?> 