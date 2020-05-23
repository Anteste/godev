<?php require 'includes/functions.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title><?= $page_title; ?></title>
</head>
<body>
    <?php require 'includes/menu.php'; ?>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h3 class="card-header"><?= $page_title; ?></h3>
                    <div class="card-body">
                        <?= $page_content; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>