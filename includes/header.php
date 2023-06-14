<header>
    <nav>
        <div>
            <a href="index.php">Accueil</a>
            <a href="menu.php">Menu</a>
        </div>
        <div>
            <?php if( empty($_SESSION) ) : ?>
                <a href="login.php">Connexion</a>
            
            <?php else : ?>
                <a href="profile.php">Profil</a>
                <a href="logout.php">Déconnexion</a>
            <?php endif ?>
        </div>
    </nav>
</header>