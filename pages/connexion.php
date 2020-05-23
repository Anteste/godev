<?php

// Le formulaire a été soumis
if (isset($_POST['pseudo']) && isset($_POST['password']))
{
    $query = getPdo()->prepare('SELECT * FROM membres WHERE pseudo = :pseudo LIMIT 1');
    $query->execute(['pseudo' => $_POST['pseudo']]);
    $result = $query->fetch();

    // Le membre n'existe pas en BDD
    if (! $result) {
        $errors->set('pseudo', 'Mauvais identifiant ou mot de passe');
        $form->set('pseudo', $_POST['pseudo']);
    }
    // Le password est invalide
    else if (! password_verify($_POST['password'], $result['password'])) {
        $form->set('pseudo', $_POST['pseudo']);
        $errors->set('pseudo', 'Mauvais identifiant ou mot de passe');
    }
    // Tout est bon !
    else {
        // On crée la session depuis les infos du membre récupérées en base
        Member::createSession($result);

        // L'utilisateur a demandé une connexion auto
        if (isset($_POST['remember'])) {
            Member::createCookie($result);
        }

        // On redirige sur la page Profil
        header('Location: index.php?page=profil');
        exit;
    }
}

?>

<?php if ($member->isLogged() === false): ?>

<form action="index.php?page=connexion" method="POST">
    <div class="form-group">
        <label for="pseudo">Pseudo</label>
        <input type="text" name="pseudo" id="pseudo" class="form-control" value="<?= $form->get('pseudo'); ?>" required>
        <?php if ($errors->has('pseudo')): ?>
            <p class="text-danger"><?= $errors->get('pseudo') ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" class="form-control" required>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="remember" id="checkbox">
        <label class="form-check-label" for="checkbox">Connexion automatique</label>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Envoyer</button>
</form>

<?php else: ?>

<div class="alert alert-info">Vous êtes déjà connecté.</div>

<?php endif; ?>
