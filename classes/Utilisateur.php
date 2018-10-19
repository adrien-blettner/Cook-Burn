<?php

class Utilisateur
{
    private $id;
    private $pseudo;
    private $email;
    private $password;
    private $isAdmin;
    static  $utilisateurNull;

    public function __construct($id, $pseudo, $email, $password, $role)
    {
        $this->id = $id;
        $this->pseudo = $pseudo;
        $this->email = $email;
        $this->password = $password;
        # TODO verif bd bool ?
        $this->isAdmin = $role;
    }

    public static function FromDbRow($dbrow)
    {
        if ($dbrow == null)
            return Utilisateur::$utilisateurNull;

        $id = $dbrow ['ID'];
        $nom = $dbrow ['PSEUDO'];
        $email = $dbrow ['EMAIL'];
        $password = $dbrow ['PASSWORD'];
        $is_admin = $dbrow ['IS_ADMIN'];
        return new Utilisateur($id, $nom, $email, $password, $is_admin);
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

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getIsAdmin()
    {
        return $this->isAdmin;
    }
}
# Initialise l'utilisateur static vide
Utilisateur::$utilisateurNull = new Utilisateur (null, null, null, null, null);