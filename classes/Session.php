<?php

/**
 * Classe wrapper qui ajoute des fonctions pour gérer la session.
 * Ce n'est pas un wrapper réutilisable dans un autre projet, les variables créer sont spécifique à notre projet (id, role ...).
 *
 * Inspiration:
 * https://blog.teamtreehouse.com/how-to-create-bulletproof-sessions
 *
 * Rappel de nos variables de session :
 *  - isConnected :  bool    Vrai si connecté faux sinon;
 *  - id :           int     L'id de l'utilisateur, -1 si pas connecté.
 *  - pseudo :       string  Le peseudo de l'utilisateur
 *  - role :         string  Le role de l'utilisateur : 'visiteur' (pas connecté), simple 'membre' ou 'admin'.
 *  - adresseIP      string  Adresse ip de l'utilisateur (combinée à l'user agent pour vérifier identité).
 *  - userAgent      string  La "plaque d'immtriculation" de l'utilisateur (navigateur, système d'exploitation ...).
 *
 * Class Session  La classe.
 */
class Session
{
    /**
     * Fonction qui (re)démarre la session.
     */
    public static function initSession ()
    {
        // Démarre la session ou récupere la session courrente (test isset car delete appel init)
        if (!isset($_SESSION)) {
            session_start();
        }

        // Vérifie que la session est secure
        if (self::mightBeenHijacking() or self::wrongValues() or self::tooOld())
        {
            self::destroySession();
            // On rappelle session_start car la fonction précdéente supprime la session, il faut la redémarrer
            session_start();
            $_SESSION['isConnected'] = false;
            $_SESSION['id'] = -1;
            $_SESSION['pseudo'] = '';
            $_SESSION['role'] = 'visiteur';
            $_SESSION['adresseIP'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
            $_SESSION['recetteAEditer'] = null;
        }
    }


    /**
     * Fonction qui vérifie que la fonction n'est pas hijackée en :
     *	   - vérifiant que l'ip est toujours la même
     *	   - vérifiant que l'user agent est toujours le même (identifie le navigateur, système exploitation ...)
     *
     * @return bool
     */
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


    /**
     * Fonction qui vérifie qu'il n'y pas de valeurs invalide.
     *
     * @return bool Les valeurs sont valides ou non.
     */
    private static function wrongValues ( )
    {
        if (!isset($_SESSION['isConnected'], $_SESSION['pseudo'], $_SESSION['role']))
            return true;

        if (!is_bool($_SESSION['isConnected']))
            return true;

        if (!in_array($_SESSION['role'], ['visiteur','membre', 'admin']))
            return true;

        return false;
    }


    /**
     * Vérifie que la session n'a pas éxpirée.
     *
     * @return bool  La session est/n'est pas trop vieille
     */
    private static function tooOld ()
    {
        if (self::isConnected())
            if (!isset($_SESSION['expiration']) or time() >= $_SESSION['expiration'])
                return true;

        return false;
    }


    /**
     * Destruction de la session.
     */
    private static function destroySession ()
    {
        $_SESSION = array();
        session_unset();
        session_destroy();
        session_write_close();
    }


    /**
     * Met à jour les valeurs de la session lors de la connexion.
     *
     * @param Utilisateur  $utilisateur  L'utilisateur qui se connecte.
     */
    public static function connect ($utilisateur)
    {
        $isAdmin = $utilisateur->getIsAdmin();
        $pseudo = $utilisateur->getPseudo();
        $id = $utilisateur->getId();


        $_SESSION['isConnected'] = true;

        $_SESSION['id'] = $id;

        $_SESSION['pseudo'] = $pseudo;

        if (!is_bool($isAdmin) or $isAdmin == false)
            $_SESSION['role'] = 'membre';
        else
            $_SESSION['role'] = 'admin';

        $_SESSION['expiration'] = time() + (60*60);
    }


    /**
     * Met à jour le pseudo (en cas de changement par exemple).
     *
     * @param string  $pseudo  Le nouveau pseudo
     */
    public static function updatePseudo ($pseudo)
    {
        $_SESSION['pseudo'] = $pseudo;
    }


    /**
     * Déconnecte l'utilisateur de la session.
     */
    public static function disconnect ()
    {
        // Approche très simple (comme un cookie souvent) :
        // mettre la date d'expiration dans le passé (5 min avant maintenant)
        $_SESSION['expiration'] = time() - (5*60);
        self::initSession();
    }

    /**
     * Test si l'utilisateur est connecté avec un compte.
     * @return  bool  Vrai si l'utilisateur est connecté, faux sinon.
     */
    public static function isConnected ()
    {
        return (isset($_SESSION['isConnected']) and $_SESSION['isConnected'] === true);
    }

    /**
     * Test si l'utilisateur est connecté et admin.
     * @return  bool  Vrai si l'utilisateur est connecté et admin.
     */
    public static function isAdmin ()
    {
        return (self::isConnected() and $_SESSION['role'] == 'admin');
    }

    /**
     * Renvoie l'id de l'utilisateur courant (-1 si non connecté).
     * @return  int|null  L'id.
     */
    public static function getID ()
    {
        return $_SESSION['id'];
    }


    /**
     * Retourne l'id de la recette qu'on souhaite éditer actuellement.
     * @return int|null
     */
    public static function getRecetteAEditer ()
    {
        return $_SESSION['recetteAEditer'];
    }

    /**
     * Fonction qui fix l'id de la recette à éditer dans la session.
     * @param int $id Le nouvelle id de recette.
     */
    public static function setRecetteAEditer ($id)
    {
        $_SESSION['recetteAEditer'] = $id;
    }
}