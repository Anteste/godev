<?php

// Le formulaire a été soumis
if (isset($_POST['pseudo']) && isset($_POST['email']))
{
    // Vérif pseudo : il n'est pas vide
    if (empty($_POST['pseudo'])) {
        $errors->set('pseudo', "Le pseudo est obligatoire");
    }
    // Vérif pseudo : il n'est pas déjà pris
    else if (Member::pseudoIsAlreadyTaken($_POST['pseudo'])) {
        $errors->set('pseudo', "Ce pseudo est déjà utilisé");
        $form->set('pseudo', $_POST['pseudo']);
    }

    // Vérif email : il n'est pas vide
    if (empty($_POST['email'])) {
        $errors->set('email', "L'email est obligatoire");
    }
    // Vérif email : il n'est pas déjà pris
    else if (Member::emailIsAlreadyTaken($_POST['email'])) {
        $errors->set('email', "Cet email est déjà utilisé");
        $form->set('email', $_POST['email']);
    }
    // Vérif email : il est au bon format
    else if (false == preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email'])) {
        $errors->set('email', "L'email n'est pas au bon format");
        $form->set('email', $_POST['email']);
    }

    // Vérif password : il n'est pas vide
    if (empty($_POST['password'])) {
        $errors->set('password', "Le mot de passe est obligatoire");
    }
    // Vérif password : il est identique à la confirmation
    else if ($_POST['password'] !== $_POST['password_confirm']) {
        $errors->set('password', "Les deux mots de passes sont différents");
    }

    // Aucune erreur dans notre formulaire,
    // on crée le membre en BDD
    if ($errors->count() === 0) {
        $query = getPdo()->prepare('INSERT INTO membres (pseudo, password, email) VALUES (:pseudo, :pass, :email)');

        $query->execute([
            'pseudo' => $_POST['pseudo'],
            'pass' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'email' => $_POST['email']
        ]);

        // On indique à notre page que l'inscription
        // a été faite
        $registered = true;
    }
}

?>

<?php if (false === isset($registered)): ?>

<form action="index.php?page=inscription" method="POST">
    <div class="row">
        <div class="col-12 col-sm-6">
            <div class="form-group">
                <label for="pseudo">Pseudo</label>
                <input type="text" name="pseudo" id="pseudo" class="form-control" value="<?= $form->get('pseudo'); ?>" required>
                <?php if ($errors->has('pseudo')): ?>
                    <p class="text-danger"><?= $errors->get('pseudo') ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-12 col-sm-6">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= $form->get('email'); ?>" required>
                <?php if ($errors->has('email')): ?>
                    <p class="text-danger"><?= $errors->get('email') ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-6">
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" class="form-control" required>
                <?php if ($errors->has('password')): ?>
                    <p class="text-danger"><?= $errors->get('password') ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-12 col-sm-6">
            <div class="form-group">
                <label for="password_confirm">Mot de passe (confirmation)</label>
                <input type="password" name="password_confirm" id="password_confirm" class="form-control" required>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Envoyer</button>
</form>

<?php else: ?>

    <div class="alert alert-info">Votre inscription a été prise en compte. Vous pouvez désormais vous <a href="index.php?page=connexion">connecter</a>.</div>

<?php endif; ?>