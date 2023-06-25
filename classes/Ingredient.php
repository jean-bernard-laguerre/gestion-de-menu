<?php 
    class Ingredient {

        public $name;
        private $pdo;

        public function __construct($name)
        {
            $this->name = $name;
            $this->pdo = new Database();
        }

        public function add() {

        }

        public function delete() {
            
        }
    }
?>