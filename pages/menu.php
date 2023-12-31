<?php
    require __DIR__ . "/../classes/Database.php";
    require __DIR__ . "/../classes/Menu.php";
    include "../functions/tools.php";

    session_start();
    $pdo = new Database();
    $imageFolder = "../assets/menu/";

    if(!empty($_POST)) {

        if (isset($_POST["register"])) {

            $title = htmlspecialchars($_POST["menu-title"]);
            $description = htmlspecialchars($_POST["menu-description"]);

            $restaurant_id = $_POST["menu-restaurant"];
            $image = $_FILES["menu-image"]['name'];
            $menu_dish = $_POST["menu-dish"];

            $newDish = new Menu($title, $description, $image, $restaurant_id);

            $newDish->add($_SESSION["id"]);
            $newDish->addDish($menu_dish);

            $image = $_FILES["menu-image"];
            $imageFile = $imageFolder . basename($_FILES["menu-image"]["name"]);
            
            if (checkImage($image, $imageFile)) {
                (move_uploaded_file($_FILES["menu-image"]["tmp_name"], $imageFile));
            }
        } elseif (isset($_POST["edit"])) {
            


        }
    }

    $restaurants = getRestaurants($pdo->bdd, $_SESSION["id"]);
    $dishes = getDishes($pdo->bdd, $_SESSION["id"]);
    $menus = getMenus($pdo->bdd, $_SESSION["id"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="module" src="../scripts/menu.js"></script>
    <link rel="stylesheet" href="../style/style.css">
    <title>Gestion de menu - Menu</title>
</head>
<body>
    <?php include "../includes/header.php" ?>
    <main>
        <?php if(!empty($_SESSION)) : ?>
            <div class="form-container">
                <form action="" method="POST" enctype="multipart/form-data">
                    <h2>Creer un menu</h2>
                    <div class="form-content">
                        <div class="flex column">
                            <input type="text" name="menu-title" placeholder="Titre" required>
                            <input type="text" name="menu-description" placeholder="Description" required>
                            <div class="flex align">
                                <label for="image-file">Image: </label>
                                <input type="file" id="image-file" name="menu-image" placeholder="Image" required>
                            </div>
                            <div class="flex align">
                                <label for="resto">Restaurant: </label>
                                &nbsp
                                <select id="resto" name="menu-restaurant" class="restaurant-select" placeholder="Restaurant" required>
                                    <?php
                                        foreach($restaurants as $restaurant){
                                            echo "<option value=" . $restaurant["id"] . ">" . $restaurant["name"] ."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-side flex column">
                            <div class="control">
                                <label for="">Plats: </label>
                                <button type="button" id="add">
                                    <img class="icon" src="../style/images/icons8-ajouter-50.png" alt="add icon">
                                </button>
                                <button type="button" id="remove">
                                    <img class="icon" src="../style/images/icons8-retirer-50.png" alt="add icon">
                                </button>
                            </div>
                            <select name="menu-dish[]" class="dish-select" placeholder="Plat" required>
                                <?php
                                    foreach($dishes as $dish){
                                        echo "<option value=" . $dish["id"] . ">" . $dish["name"] ."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <input type="submit" name="register" value="Créer">
                </form>
            </div>

            <div id="edit" class="form-container hidden">
                <button id="close-button">
                    <img class="icon" src="../style/images/icons8-effacer-50.png" alt="add icon">
                </button>
                <form action="" method="POST" enctype="multipart/form-data">
                    <h2>Editer le menu</h2>
                    <div class="form-content">
                        <div class="flex column">
                            <input type="text" name="edit-title" placeholder="Titre" required>
                            <input type="text" name="edit-description" placeholder="Description" required>
                            <div class="flex align">
                                <label for="edit-image-file">Image: </label>
                                <input type="file" id="edit-image-file" name="edit-image" placeholder="Image" required>
                            </div>
                            <div class="flex align">
                                <label for="edit-resto">Restaurant: </label>
                                &nbsp
                                <select id="edit-resto" name="edit-restaurant" class="restaurant-select" placeholder="Restaurant" required>
                                    <?php
                                        foreach($restaurants as $restaurant){
                                            echo "<option value=" . $restaurant["id"] . ">" . $restaurant["name"] ."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-side flex column">
                            <div class="control">
                                <label for="">Plats: </label>
                                <button type="button" id="edit-add">
                                    <img class="icon" src="../style/images/icons8-ajouter-50.png" alt="add icon">
                                </button>
                                <button type="button" id="edit-remove">
                                    <img class="icon" src="../style/images/icons8-retirer-50.png" alt="add icon">
                                </button>
                            </div>
                            <select name="menu-dish[]" class="edit-dish-select" placeholder="Plat" required>
                                <?php
                                    foreach($dishes as $dish){
                                        echo "<option value=" . $dish["id"] . ">" . $dish["name"] ."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <input type="submit" name="edit" value="Modifier">
                </form>
            </div>

        <?php endif ?>
        <h2>Mes menus</h2>
        <div class="list-container">
            <?php
                foreach($menus as $menu){

                    $dishes = getMenuDishes($pdo->bdd, $menu["id"]);

                    echo "<div class='menu-container'>";
                    echo "<img src='". $imageFolder . $menu["image"] . "' alt=" . $menu["name"] ." />";
                    echo "<div class='menu-content'>";

                    echo "<h3>" . $menu["name"] . "</h3>";
                    echo "<p>" . $menu["description"] . "</p>";
                    echo "<h4>Plats:</h4>";

                    foreach($dishes as $dish){
                        echo "<li>" . $dish["name"] . " " . $dish["price"] . "€</li>";
                    }
                    
                    echo "</div>";
                    echo "<hr>";

                    if ($_SESSION["id"] == 1 || $menu["author_id"] == $_SESSION["id"]) {
                        echo "<div class='control'>";
                        echo "<button type='button' class='remove-menu' id=" . $menu["id"] .">";
                        echo "<img class='icon' src='../style/images/icons8-supprimer-48.png' alt='delete icon'>";
                        echo "</button>";
                        echo "<button type='button' class='edit-menu' id=" . $menu["id"] .">";
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