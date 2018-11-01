<?php

/**
 * Classe qui permet de créer un objet utilisateur contenant tout les attibuts d'une utilisateur.
 *
 * il n'y a pas d'attributs contenant le mot de passe car çela n'a pas d'interêt et donc si on peut éviter de laisser trainer le mdp c'est mieux.
 *
 * Class Utilisateur
 */
class Utilisateur
{
    /**
     * l'id de l'utilisateur.
     * @var int
     */
    private $id;

    /**
     * Le pseudo de l'utilisateur.
     * @var string
     */
    private $pseudo;

    /**
     * Le mail de l'utilisateur.
     * @var string
     */
    private $email;

    /**
     * Bool qui determine le statut admin ou non de l'utilisateur.
     * @var bool
     */
    private $isAdmin;

    /**
     * Un utilisateur vide.
     * @var Utilisateur
     */
    static  $utilisateurNull;

    /**
     * Constructeur de la classe utilisateur.
     *
     * @param  int     $id       L'id de l'utilisateur
     * @param  string  $pseudo   Le pseudo.
     * @param  string  $email    Son mail.
     * @param  int     $isAdmin  Le statut de l'utilisateur.
     */
    public function __construct($id, $pseudo, $email, $isAdmin)
    {
        $this->id = $id;
        $this->pseudo = $pseudo;
        $this->email = $email;

        if ($isAdmin === null)
            $this->isAdmin = null;
        else {
            if (is_bool($isAdmin))
                $this->isAdmin = $isAdmin;
            else
                $this->isAdmin = boolval($isAdmin);
        }
    }

    /**
     * Un "constructeur" alternatif, qui va directement prendre un array extrait d'un mysqli result et renvoyé une instance d'utilisateur correspondant.
     *
     * @param   array        $dbRow  L'array extrait d'un résultat d'une requête sur la table MEMBRE.
     * @return  Utilisateur
     */
    public static function FromDbRow($dbRow)
    {
        if ($dbRow === null or $dbRow === false)
            return Utilisateur::$utilisateurNull;

        $id = $dbRow ['ID'];
        $nom = $dbRow ['PSEUDO'];
        $email = $dbRow ['EMAIL'];
        $isAdmin = $dbRow ['IS_ADMIN'];
        return new Utilisateur($id, $nom, $email, $isAdmin);
    }

    /**
     * Retourne l'id de l'utilisateur.
     *
     * @return  int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Renvoie le pseudo de l'utilisateur.
     *
     * @return  string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Renvoie le mail de l'utilisateur
     *
     * @return  string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Renvoie vrai si lu'tilisateur est admin.
     *
     * @return  mixed
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }
}
# Initialise l'utilisateur static vide
Utilisateur::$utilisateurNull = new Utilisateur (null, null, null, null);