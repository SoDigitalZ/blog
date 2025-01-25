<?php

namespace App\Core;

class Session
{
    /**
     * Démarre la session si elle n'est pas déjà démarrée.
     */
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Définit une valeur dans la session.
     *
     * @param string $key La clé sous laquelle stocker la valeur.
     * @param mixed $value La valeur à stocker.
     */
    public static function set(string $key, mixed $value): void
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    /**
     * Récupère une valeur de la session.
     *
     * @param string $key La clé à récupérer.
     * @param mixed $default La valeur par défaut si la clé n'existe pas.
     * @return mixed La valeur stockée ou la valeur par défaut.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Vérifie si une clé existe dans la session.
     *
     * @param string $key La clé à vérifier.
     * @return bool True si la clé existe, false sinon.
     */
    public static function has(string $key): bool
    {
        self::start();
        return isset($_SESSION[$key]);
    }

    /**
     * Supprime une clé de la session.
     *
     * @param string $key La clé à supprimer.
     */
    public static function delete(string $key): void
    {
        self::start();
        unset($_SESSION[$key]);
    }

    /**
     * Ajoute un message flash dans la session.
     *
     * @param string $key La clé sous laquelle stocker le message.
     * @param mixed $value Le message à stocker.
     */
    public static function flash(string $key, mixed $value): void
    {
        self::set($key, $value);
    }

    /**
     * Récupère un message flash puis le supprime.
     *
     * @param string $key La clé à récupérer.
     * @return mixed|null Le message flash ou null si inexistant.
     */
    public static function getFlash(string $key): mixed
    {
        $value = self::get($key);
        self::delete($key);
        return $value;
    }

    /**
     * Détruit complètement la session.
     */
    public static function destroy(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }
    }
}
