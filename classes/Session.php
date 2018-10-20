<?php

# Inspiration:
# https://blog.teamtreehouse.com/how-to-create-bulletproof-sessions

class Session
{
    # Fonction qui démarre la session
    public static function initSession ()
    {
        # Démarre la session ou récupere la session courrente
        session_start();

        # Vérifie que la session est secure
        if (self::mightBeenHijacking() or self::wrongValues())
        {
            self::destroySession();
            # On rappelle session_start car la fonction précdéente supprime la session, il faut la redémarrer
            session_start();
            $_SESSION['isConnected'] = false;
            $_SESSION['pseudo'] = '';
            $_SESSION['role'] = 'visiteur';
            $_SESSION['adresseIP'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
        }
    }


    # Fonction qui vérifie que la fonction n'est pas hijackée en :
    #		- vérifiant que l'ip est toujours la même
    #		- vérifiant que l'user agent est toujours le même (identifie le navigateur, système exploitation ...)
    private static function mightBeenHijacking ()
    {
        if(!isset($_SESSION['adresseIP']) || !isset($_SESSION['userAgent']))
            return true;

        if ($_SESSION['adresseIP'] != $_SERVER['REMOTE_ADDR'])
            return true;

        if ($_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT'])
            return true;

        return false;
    }

    # Fonction qui vérifie qu'il n'y pas de valeurs invalide (sauf pseudo ça serait trop génant)
    private static function wrongValues ( )
    {
        if (!isset($_SESSION['isConnected'], $_SESSION['pseudo'], $_SESSION['role']))
            return true;

        if ($_SESSION['isConnected'] !== True)
            return true;

        if (!in_array($_SESSION['role'], ['visiteur','membre', 'admin']))
            return true;

        return false;
    }

    # Fonction qui supprime la session
    private static function destroySession ()
    {
        $_SESSION = array();
        session_unset();
        session_destroy();
        session_write_close();
    }
}