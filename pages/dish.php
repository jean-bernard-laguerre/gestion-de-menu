<?php
    require __DIR__ . "/../classes/Database.php";
    require __DIR__ . "/../classes/Dish.php";
    include "../functions/tools.php";

    session_start();
    $pdo = new Database();
    $imageFolder = "../assets/dish/";

    if(!empty($_POST)) {

        if (isset($_POST["register"])) {

            $title = htmlspecialchars($_POST["dish-title"]);
            $price = htmlspecialchars($_POST["dish-price"]);
            $description = htmlspecialchars($_POST["dish-description"]);

            $imageName = $_FILES["dish-image"]['name'];
            $ingredients = $_POST["dish-ingredient"];
            $category = (int) $_POST["dish-category"];

            $newDish = new Dish($title, $price, $imageName, $description, $category);
            
            $newDish->add($_SESSION["id"]);
            $newDish->addIngredient($ingredients);  

            $image = $_FILES["dish-image"];
            $imageFile = $imageFolder . basename($_FILES["dish-image"]["name"]);
            
            if (checkImage($image, $imageFile)) {
                (move_uploaded_file($_FILES["dish-image"]["tmp_name"], $imageFile));
            }
        } elseif (isset($_POST["edit"])) {
            
        }

    }
    
    $categories = getCategories($pdo->bdd, $_SESSION["id"]);
    $dishes = getDishes($pdo->bdd, $_SESSION["id"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="module" src="../scripts/dish.js"></script>
    <link rel="stylesheet" href="../style/style.css">
    <title>Gestion de menu - Plats</title>
</head>
<body>
    <?php include "../includes/header.php" ?>
    <main>
        <?php if(!empty($_SESSION)) : ?>

            <div class="form-container">
                <form action="" method="POST" enctype="multipart/form-data">
                    <h2>Ajouter un plat</h2>
                    <div class="form-content">
                        <div class="flex column">
                            <input type="text" name="dish-title" placeholder="Titre" required>
                            <input type="text" name="dish-price" placeholder="Prix" required>
                            <input type="text" name="dish-description" placeholder="Description" required>

                            <div class="flex align">
                                <label for="image-file">Image: </label>
                                <input type="file" id="image-file" name="dish-image" placeholder="Image" required>
                            </div>

                            <div class="flex align">
                                <label for="cat">Categorie: </label>
                                &nbsp
                                <select id="cat" name="dish-category" placeholder="Category" required>
                                    <?php
                                        foreach($categories as $category){
                                            echo "<option value=" . $category["id"] . ">" . $category["name"] ."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-side flex column">
                            <div class="control">
                                <label for="">Ingredients: </label>
                                <button type="button" id="add">
                                    <img class="icon" src="../style/images/icons8-ajouter-50.png" alt="add icon">
                                </button>
                                <button type="button" id="remove">
                                    <img class="icon" src="../style/images/icons8-retirer-50.png" alt="add icon">
                                </button>
                            </div>
                            <input type="text" name="dish-ingredient[]" class="ingredient-input" placeholder="Ingredient" required>
                        </div>
                    </div>

                    <input type="submit" name="register" value="Ajouter">
                </form>
            </div>

            <div id="edit" class="form-container hidden">
                <button id="close-button">
                    <img class="icon" src="../style/images/icons8-effacer-50.png" alt="add icon">
                </button>
                <form action="" method="POST" enctype="multipart/form-data">
                    <h2>Editer le plat</h2>
                    <div class="form-content">
                        <div class="flex column">
                            <input type="text" name="edit-title" placeholder="Titre" required>
                            <input type="text" name="edit-price" placeholder="Prix" required>
                            <input type="text" name="edit-description" placeholder="Description" required>

                            <div class="flex align">
                                <label for="edit-file">Image: </label>
                                <input type="file" id="edit-file" name="edit-image" placeholder="Image" required>
                            </div>

                            <div class="flex align">
                                <label for="cat">Categorie: </label>
                                &nbsp
                                <select id="cat" name="edit-category" placeholder="Category" required>
                                    <?php
                                        foreach($categories as $category){
                                            echo "<option value=" . $category["id"] . ">" . $category["name"] ."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-side flex column">
                            <div class="control">
                                <label for="">Ingredients: </label>
                                <button type="button" id="edit-add">
                                    <img class="icon" src="../style/images/icons8-ajouter-50.png" alt="add icon">
                                </button>
                                <button type="button" id="edit-remove">
                                    <img class="icon" src="../style/images/icons8-retirer-50.png" alt="add icon">
                                </button>
                            </div>
                            <input type="text" name="edit-ingredient[]" class="edit-ingredient" placeholder="Ingredient" required>
                        </div>
                    </div>

                    <input type="submit" name="edit" value="Editer">
                </form>
            </div>

        <?php endif ?>
        <h2>Mes plats</h2>
        <div class="list-container">
            <?php
                foreach($dishes as $dish){
                    $ingredients = getDishIngredients($pdo->bdd, $dish["id"]);

                    echo "<div class='dish-container'>";
                    echo "<img src=". $imageFolder . $dish["image"] ." alt=" . $dish["name"] ." />";
                    echo "<div class='dish-content'>";

                    echo "<h3>" . $dish["name"] . "</h3>";
                    echo "<p>" . $dish["price"] . "€</p>";
                    echo "<p>" . $dish["category_name"] . ": " . $dish["description"] . "</p>";
                    echo "<h4>Ingredients:</h4>";

                    foreach($ingredients as $ingredient){
                        echo "<li>" . $ingredient["ingredient"] . "</li>";
                    }
                    
                    echo "</div>";
                    echo "<hr>";

                    if ($_SESSION["id"] == 1 || $dish["author_id"] == $_SESSION["id"]) {
                        echo "<div class='control'>";
                        echo "<button type='button' class='remove-dish' id=" . $dish["id"] . ">";
                        echo "<img class='icon' src='../style/images/icons8-supprimer-48.png' alt='delete icon'>";
                        echo "</button>";
                        echo "<button type='button' class='edit-dish' id=" . $dish["id"] .">";
                        echo "<img class='icon' src='../style/images/icons8-modifier-50.png' alt='edit icon'>";
                        echo "</button>";
                        echo "</div>";
                    }
                    
                    echo "</div>";
                }
            ?>
        </div>
    </main>
    <?php include "../includes/footer.php" ?>
</body>
</html>