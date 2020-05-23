<?php

/**
 * Cette classe va nous permettre de contrôler
 * les message d'erreurs de nos formulaires
 */
class Errors
{
    private $errors = [];

    public function __construct()
    {
        // A chaque instance on s'assure que notre tableau est vide
        $this->errors = [];
    }

    /**
     * Ajoute une nouvelle erreur
     *
     * @param string $key La clé de l'erreur. Ex : pseudo, password
     * @param string $message Le message. Ex : Le pseudo est déjà utilisé
     */
    public function set(string $key, string $message): void
    {
        $this->errors[$key] = $message;
    }

    /**
     * Récupère un message d'erreur pour une clé
     *
     * @param string $key La clé de l'erreur. Ex : pseudo
     * @return string|null Le message d'erreur stocké ou NULL s'il n'y en avait pas
     */
    public function get(string $key): ?string
    {
        if ($this->has($key)) {
            return $this->errors[$key];
        }

        return null;
    }

    /**
     * Vérifie qu'une erreur existe pour une clé
     *
     * @param string $key La clé de l'erreur. Ex : pseudo
     * @return bool Oui ou non une erreur existe
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->errors);
    }

    /**
     * Compte le nombre d'erreur
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->errors);
    }
}
