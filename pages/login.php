<?php

    require __DIR__ . '/../classes/User.php';

    session_start();

    $login_message = "";
    $register_message = "";

    function testPassword($pass){

        /* Conditions du mot de passe avec regex et message d'erreur  */
        $conditions = [ ["Doit contenir au moins une lettre majuscule.", '/[A-Z]/'],
                        ["Doit contenir au moins une lettre minuscule.", '/[a-z]/'],
                        ["Doit contenir au moins un chiffre.", '/\d/'],
                        ["Doit contenir au moins un caractère spécial.", "/[\'^£$%&*()}{@#~?><>,|=_+¬-]/"]];

        $errors = [];

        if(strlen($pass) < 8){
            array_push( $errors, "Doit avoir au moins 8 charactère" );
        }
        /* Boucle qui test chaque conditions pour le mot de passe et ajoute le message d'erreur a l'array si le test echoue */
        foreach( $conditions as $condition ){
            if( !preg_match( $condition[1], $pass )){
                array_push( $errors, $condition[0] );
            }
        }

        return $errors;
    }

    if (isset($_POST["register"])){

        $username = $_POST["register-login"];
        $password = $_POST["register-password"];

        $passtest = testPassword( $password );
        
        // Teste si les différent champs sont remplis
        if( empty($username)){
            $register_message = "Entrer login";
        }
        elseif( empty($password) || count($passtest) > 0 ){
            $register_message = "Mot de passe invalide.";
        }
        elseif( $password != $_POST["confirm-pass"] ){
            $register_message = "Veuillez confirmer le mot de passe.";
        }
        else {

            $user = new User($username); 
            
            // Ajout de l'utilisateur a la base de données si le formulaire est valide et l'utilisateur n'existe pas déja
            if ($user->register($password)) {
                header("location: menu.php");
            } else {
                $register_message = "Ce nom d'utilisateur est déja utilisé";
            }
        }
    }

    if (isset($_POST["connect"])){

        $username = $_POST["login"];
        $password = $_POST["password"];

        $passtest = testPassword( $password );
        
        // Teste si les différent champs sont remplis
        if( empty($username) || empty($password)){
            $login_message = "Entrer login et password";
        }
        else {

            $user = new User($username); 
            
            // Connexion de l'utilisateur si l'utilisateur existe et le mot de passe est le bon
            if ($user->connect($password)) {
                header("location: menu.php");
            } else {
                $login_message = "Login ou password incorrect";
            }
        }
    }
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
        <div class="form-container">
            <form action="" method="POST">
                <h2>Connexion</h2>
                <?php 
                    if( !empty($login_message) ){
                        echo $login_message . "</br>";
                    }
                ?>
                <input type="text" name="login" placeholder="Login" required>
                <input type="password" name="password" placeholder="Mot de passe" required>
                <input type="submit" name="connect" value="Connexion">
            </form>
        </div>
        <div class="form-container">
            <form action="" method="POST">
                <h2>Creation de compte</h2>
                <?php 
                    if( !empty($register_message) ){
                        echo $register_message . "</br>";;
                        foreach( $passtest as $error ){
                            echo $error . "</br>";
                        }
                    }
                ?>
                <input type="text" name="register-login" placeholder="Login" required>
                <input type="password" name="register-password" placeholder="Mot de passe" required>
                <input type="password" name="confirm-pass" placeholder="Confirmer mot de passe" required>
                <input type="submit" name="register" value="Inscription">
            </form>
        </div>
    </main>
    <?php include "../includes/footer.php" ?>
</body>
</html>