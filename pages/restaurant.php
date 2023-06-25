<?php
    require __DIR__ . "/../classes/Database.php";
    require __DIR__ . "/../classes/Restaurant.php";
    include "../functions/tools.php";

    session_start();
    $pdo = new Database();

    if(!empty($_POST)) {
        
        if (!empty($_POST)) {

            $name = $_POST["restaurant-name"];
            
            $newRestaurant = new Restaurant($name);
    
            $newRestaurant->add($_SESSION["id"]);
    
        }
    }

    $restaurants = getRestaurants($pdo->bdd, $_SESSION["id"]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="../scripts/restaurant.js"></script>
    <link rel="stylesheet" href="../style/style.css">
    <title>Gestion de menu - Restaurant</title>
</head>
<body>
    <?php include "../includes/header.php" ?>
    <main>
        <?php if(!empty($_SESSION)) : ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <h2>Créer un restaurant</h2>

                <input type="text" name="restaurant-name" placeholder="Nom" required>
                <input type="submit" name="register" value="Ajouter">
            </form>

            <div id="edit" class="form-container hidden">
                <button id="close-button">
                    <img class="icon" src="../style/images/icons8-effacer-50.png" alt="add icon">
                </button>
                <form action="" method="POST">
                    <h2>Editer restaurant</h2>
                    <input type="text" name="edit-name" placeholder="Titre" required>
                    <input type="submit" name="edit" value="Editer">
                </form>
            </div>
        <?php endif ?>
        <div class="list-container">
            <table>
                <caption>
                    <h2>Mes Restaurant</h2>
                </caption>
                <thead>
                    <td>Nom</td>
                </thead>
                <tbody>
                    <?php
                        foreach($restaurants as $restaurant){
                            echo "<tr>";
                            echo "<td>" . $restaurant["name"] . "</td>";
                            echo "<td>";
                            
                            if ($_SESSION["id"] == 1 || $restaurant["owner_id"] == $_SESSION["id"]) {
                                echo "<div class='control'>";
                                echo "<button type='button' class='remove' id=" . $restaurant["id"] .">";
                                echo "<img class='icon' src='../style/images/icons8-supprimer-48.png' alt='delete icon'>";
                                echo "</button>";
                                echo "<button type='button' class='edit' id=" . $restaurant["id"] .">";
                                echo "<img class='icon' src='../style/images/icons8-modifier-50.png' alt='edit icon'>";
                                echo "</button>";
                                echo "</div>";
                            }
                            
                            echo "</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
                <img src="" alt="">
            </table>
        </div>
    </main>
    <?php include "../includes/footer.php" ?>
</body>
</html>