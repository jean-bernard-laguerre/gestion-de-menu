<?php
    class Category{

        private $pdo;
        public $name;

        function __construct($name)
        {
            $this->pdo = new Database();
            $this->name = $name;
        }

        function add() {
            $sql = "INSERT INTO category (name)
                    VALUES (?)";

            $req = $this->pdo->bdd->prepare($sql);
            $req->execute([$this->name]);
        }

        function remove() {
            $sql = "DELETE FROM category
                    WHERE name = ?";

            $req = $this->pdo->bdd->prepare($sql);
            $req->execute([$this->name]);
        }
    }
?>