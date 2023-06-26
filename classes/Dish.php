<?php 
    class Dish{
        
        private $pdo;
        public $id;
        public $name;
        public $price;
        public $image;
        public $description;
        public $category;
        
        public function __construct($name, $price, $image, $description, $category)
        {
            $this->name = $name;
            $this->image = $image;
            $this->price = $price;
            $this->category = $category;
            $this->description = $description;
            $this->pdo = new Database();
        }

        public function add($author_id) {

            $sql = "INSERT INTO dish (name, price, description, image, category_id, author_id)
                    VALUES (?,?,?,?,?,?)";
            $req = $this->pdo->bdd->prepare($sql);
            $req->execute( [$this->name, $this->price, $this->description,
                            $this->image, $this->category, $author_id] );

            $this->id = $this->pdo->bdd->lastInsertId();
        }

        public function edit($id) {

            $this->id = $id;

            $sql = "UPDATE dish 
            SET name = ?, price = ?, description = ?, image = ?, category_id = ?,
            WHERE id = ?";

            $req = $GLOBALS["bdd"]->prepare($sql);
            $req->execute( [$this->name, $this->price, $this->description, $this->image, $this->category, $this->id] );
        }

        public function addIngredient($ingredients) {
            foreach($ingredients as $ingredient){
                $sql[] = '('. $this->id . ',"' .$ingredient.'")';
            }
            $req = $this->pdo->bdd->prepare("INSERT INTO dish_ingredient (dish_id, ingredient)
                                             VALUES" . implode(",", $sql));
            $req->execute();
        }

        public function removeIngredient($ingredients) {

        }
    }
?>