<?php

class Utilisateur
{
    private $id;
    private $pseudo;
    private $email;
    private $password;
    private $is_admin;
    static  $utilisateurNull;

    public function __construct($id, $pseudo, $email, $password, $is_admin)
    {
        $this->id = $id;
        $this->pseudo = $pseudo;
        $this->email = $email;
        $this->password = $password;
        # TODO verif bd bool ?
        $this->is_admin = $is_admin;
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

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getisAdmin()
    {
        return $this->is_admin;
    }

    public function setIsAdmin($is_admin)
    {
        $this->is_admin = $is_admin;
    }
}
# Initialise l'utilisateur static vide
Utilisateur::$utilisateurNull = new Utilisateur (null, null, null, null, null);