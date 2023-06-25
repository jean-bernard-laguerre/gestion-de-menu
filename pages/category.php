<?php
    require __DIR__ . "/../classes/Database.php";
    require __DIR__ . "/../classes/Category.php";
    include "../functions/tools.php";

    session_start();
    $pdo = new Database();

    if (!empty($_POST)) {

        $name = $_POST["category-name"];
        
        $newCategory = new Category($name);

        $newCategory->add();

    }

    $categories = getCategories($pdo->bdd);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="../scripts/category.js"></script>
    <link rel="stylesheet" href="../style/style.css">
    <title>Gestion de menu - Categories</title>
</head>
<body>
    <?php include "../includes/header.php" ?>
    <main>
        <?php if(!empty($_SESSION)) : ?>

            <div class="form-container">
                <form action="" method="POST">
                    <h2>Ajouter une categorie</h2>
                    <input type="text" name="category-name" placeholder="Titre" required>
                    <input type="submit" name="register" value="Créer">
                </form>
            </div>

            <div id="edit" class="form-container hidden">
                <button id="close-button">
                    <img class="icon" src="../style/images/icons8-effacer-50.png" alt="add icon">
                </button>
                <form action="" method="POST">
                    <h2>Editer categorie</h2>
                    <input type="text" name="edit-name" placeholder="Titre" required>
                    <input type="submit" name="edit" value="Editer">
                </form>
            </div>

        <?php endif ?>
        <div class="list-container">
            <table>
                <caption>
                    <h2>Liste des categories</h2>
                </caption>
                <thead>
                    <td>Nom</td>
                </thead>
                <tbody>
                    <?php
                        foreach($categories as $category){
                            echo "<tr>";
                            echo "<td>" . $category["name"] . "</td>";
                            echo "<td>";

                            if ($_SESSION["id"] == 1) {
                                
                                echo "<div class='control'>";
                                echo "<button type='button' class='remove' id=" . $category["id"] .">";
                                echo "<img class='icon' src='../style/images/icons8-supprimer-48.png' alt='delete icon'>";
                                echo "</button>";
                                echo "<button type='button' class='edit' id=" . $category["id"] .">";
                                echo "<img class='icon' src='../style/images/icons8-modifier-50.png' alt='edit icon'>";
                                echo "</button>";
                                echo "</div>";
                                
                                echo "</td>";
                                echo "</tr>";
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
    <?php include "../includes/footer.php" ?>
</body>
</html>