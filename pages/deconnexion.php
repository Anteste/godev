<?php

$_SESSION = [];
session_destroy();

setcookie('member_id', '', -1);
setcookie('member_hash', '', -1);

header('Location: index.php?page=connexion');
