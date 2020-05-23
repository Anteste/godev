<?php

// Démarage de la session PHP
// https://www.php.net/manual/fr/function.session-start.php
session_start();

/**
 * Récupère les variables de config depuis le fichier includes/config.php
 *
 * @return array
 */
function getConfig(): array {
    // Variable de fonction statique
    // Explication : https://www.php.net/manual/fr/language.variables.scope.php#language.variables.scope.static
    static $config = null;

    // Si la config n'a pas encore été récupéré on la récupère
    if (is_null($config)) {
        $config = include('config.php');
    }

    return $config;
}

/**
 * Crée une connexion à la BDD avec PDO et la retourne
 *
 * @return PDO
 */
function createPdo(): PDO {
    $config = getConfig();

    try {
        // Explication : https://www.php.net/manual/fr/function.vsprintf.php
        $dsn = vsprintf('mysql:host=%s;port=%d;dbname=%s;charset=utf8', [
            $config['db_host'],
            $config['db_port'],
            $config['db_name'],
        ]);

        $pdo = new PDO($dsn, $config['db_user'], $config['db_pass'], [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
    } catch (\Exception $e) {
        die('Erreur de base de données : ' . $e->getMessage());
    }

    return $pdo;
}

/**
 * Récupére l'insance de connexion à la base de données
 *
 * @return PDO
 */
function getPdo(): PDO {
    static $pdo = null;

    // Si PDO n'a pas encore été initialisé on la crée
    if (is_null($pdo)) {
        $pdo = createPdo();
    }

    return $pdo;
}

require 'classes/member.php';
$member = new Member();

require 'classes/form.php';
$form = new Form();

require 'classes/errors.php';
$errors = new Errors();

/**
 * Retourne la page courante depuis la variable d'URL $_GET
 *
 * @return array
 */
function pageGetCurrent(): array {
    // Lit la liste des pages depuis la config
    // Explication : https://www.php.net/manual/fr/language.types.array.php#example-67
    $pages = getConfig()['pages'];

    // Lit la page par défaut depuis la config
    $default = getConfig()['default_page'];

    // Page courante si défini ou page par défaut
    // Explication : https://www.php.net/manual/fr/language.operators.comparison.php#language.operators.comparison.coalesce
    $page = $_GET['page'] ?? $default;

    if (array_key_exists($page, $pages)) {
        return $pages[$page];
    }

    // Retourne la page 404 si la page courante n'existe pas
    return $pages['404'];
}

// Récupére les infos de la page courante
$page = pageGetCurrent();

// Si la page courante est protégée et que l'utilisateur n'est pas connecté,
// on redirige vers la page de connexion
if ($page['protected'] === true && $member->isLogged() === false) {
    header('Location: index.php?page=connexion');
    exit;
}

// Définit le titre de la page
$page_title = $page['title'];

// La section un peu complexe (https://www.php.net/manual/fr/function.ob-start)
// On indique à PHP qu'on va capturer tout le contenu
ob_start();
// On inclut notre page de contenu
require sprintf('pages/%s', $page['file']);
// On met tout le contenu récupéré dans notre variable
$page_content = ob_get_contents();
// On arrête la capture
ob_end_clean();
