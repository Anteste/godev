<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">Espace Membres</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php if ($member->isLogged()): ?>
                    <li class="nav-item"><a class="nav-link" href="index.php?page=profil">Profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?page=deconnexion">Déconnexion</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="index.php?page=connexion">Connexion</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?page=inscription">Inscription</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
