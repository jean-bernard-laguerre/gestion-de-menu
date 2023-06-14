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
    <script type="text/javascript" src="scripts/script.js"></script>
    <title>Module de connexion - Inscription</title>
</head>
<body>
    <?php include "../includes/header.php" ?>
    <main>
        <?php if (!empty($_SESSION)) : ?>
            <div class="form-container">
                <h2>Editer profil</h2>
                <?php
                    echo "<input id='login' value=" . $_SESSION["login"] . ">";
                ?>
                <input type="password" id='password' placeholder='Nouveau mot de passe'>
                <input type='submit' id='submit' value='Modifier'>
            </div>
        <?php endif ?>
    </main>
    <?php include "../includes/footer.php" ?>
</body>
</html>