<?php

class Utilisateur
{
    private $id;
    private $pseudo;
    private $email;
    private $isAdmin;
    static  $utilisateurNull;

    public function __construct($id, $pseudo, $email, $role)
    {
        $this->id = $id;
        $this->pseudo = $pseudo;
        $this->email = $email;
        # TODO verif bd bool ?
        $this->isAdmin = $role;
    }

    public static function FromDbRow($dbrow)
    {
        if ($dbrow === null or $dbrow === false)
            return Utilisateur::$utilisateurNull;

        $id = $dbrow ['ID'];
        $nom = $dbrow ['PSEUDO'];
        $email = $dbrow ['EMAIL'];
        $is_admin = $dbrow ['IS_ADMIN'];
        return new Utilisateur($id, $nom, $email, $is_admin);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getIsAdmin()
    {
        return $this->isAdmin;
    }
}
# Initialise l'utilisateur static vide
Utilisateur::$utilisateurNull = new Utilisateur (null, null, null, null);