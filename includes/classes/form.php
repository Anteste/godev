<?php

/**
 * Cette classe va nous permettre de stocker et d'afficher
 * les valeurs des infos d'un formulaire. Très utile pour
 * ne pas perdre une info d'un input après une erreur de validation
 */
class Form
{
    private $values = [];

    public function __construct()
    {
        // Tableau vide à la création
        $this->values = [];
    }

    /**
     * Sauvegarde une nouvelle valeur de formulaire
     *
     * @param string $key La clé à stocker. Ex : pseudo
     * @param string $value La valeur à stocker. Ex : Romain
     */
    public function set(string $key, string $value): void
    {
        // On nettoie la variable avec htmlspecialchars
        // Explication : https://www.php.net/manual/fr/function.htmlspecialchars.php
        $this->values[$key] = htmlspecialchars($value);
    }

    /**
     * Récupére une valeur de formulaire ou NULL si elle n'existe pas
     *
     * @param string $key La clé à récupérer. Ex : pseudo
     * @return string|null La valeur déjà stockée. Ex : Romain (ou NULL)
     */
    public function get(string $key): ?string
    {
        if (array_key_exists($key, $this->values)) {
            return $this->values[$key];
        }

        return null;
    }
}
