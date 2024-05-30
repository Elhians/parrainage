<header>
    <h1>Plateforme de Parrainage</h1>
    <nav>
        <a href="index.php">Accueil</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <?php if ($_SESSION['role'] == 'admin'): ?>
                <a href="admin.php">Administration</a>
            <?php endif; ?>
            <a href="dashboard.php">Tableau de bord</a>
            <a href="logout.php">Déconnexion</a>
        <?php else: ?>
            <a href="pages/login.php">Connexion</a>
            <a href="pages/register.php">Inscription</a>
        <?php endif; ?>
    </nav>
</header>
