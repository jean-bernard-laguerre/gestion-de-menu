<?php 
    class Restaurant{

        private $pdo;
        public $name;


        public function __construct($name)
        {
            $this->name = $name;
            $this->pdo = new Database();
        }

        public function add($owner_id) {

            $sql = "INSERT INTO restaurant (name, owner_id)
                    VALUES (?,?)";

            $req = $this->pdo->bdd->prepare($sql);
            $req->execute([$this->name, $owner_id]);
            
        }

        public function edit($id) {

            $sql = "UPDATE restaurant 
            SET name = ?,
            WHERE id = ?";

            $req = $GLOBALS["bdd"]->prepare($sql);
            $req->execute( [$this->name, $id] );
        }
    }
?>