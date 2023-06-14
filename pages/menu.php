<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Module de connexion - Inscription</title>
</head>
<body>
    <?php include "../includes/header.php" ?>
    <main>
        <?php if(!empty($_SESSION)) : ?>
            <div class="container">
                <h2>
                    <?php {echo "Menu " . $_SESSION["login"] . ".";}?>
                </h2>
            </div>
        <?php endif ?>
    </main>
    <?php include "../includes/footer.php" ?>
</body>
</html>