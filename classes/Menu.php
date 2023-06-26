<?php 
    class Menu{

        private $pdo;
        public $id;
        public $name;
        public $description;
        public $restaurant;
        public $image;

        public function __construct($name, $description, $image, $restaurant)
        {
            $this->name = $name;
            $this->image = $image;
            $this->description = $description;
            $this->restaurant = $restaurant;
            $this->pdo = new Database();
        }

        public function add($author_id) {

            $sql = "INSERT INTO menu (name, description, image, restaurant_id, author_id)
                    VALUES (?,?,?,?,?)";
            $req = $this->pdo->bdd->prepare($sql);
            $req->execute( [$this->name, $this->description,
                            $this->image, $this->restaurant, $author_id] );

            $this->id = $this->pdo->bdd->lastInsertId();
        }

        public function edit($id) {

            $this->id = $id;

            $sql = "UPDATE menu 
            SET name = ?, description = ?, image = ?, restaurant_id = ?,
            WHERE id = ?";

            $req = $GLOBALS["bdd"]->prepare($sql);
            $req->execute( [$this->name, $this->description, $this->image, $this->restaurant, $this->id] );
        }

        public function addDish($dishes) {
            foreach($dishes as $dish){
                $sql[] = '('. $this->id . ',"' .$dish.'")';
            }
            $req = $this->pdo->bdd->prepare("INSERT INTO menu_dish (menu_id, dish_id)
                                             VALUES" . implode(",", $sql));
            $req->execute();
        }

        public function removeDish($dish) {

        }
    }
?>