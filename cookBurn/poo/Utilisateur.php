<?php
require_once 'models/dataBaseRequest.php';

class Utilisateur
{
    private $id;
    private $nom;
    private $email;
    private $password;
    private $is_admin;

    public function __construct($id, $nom, $email, $password, $is_admin)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->email = $email;
        $this->password = $password;
        $this->is_admin = $is_admin;
    }

    public static function FromDbRow($dbrow)
    {
        $id = $dbrow ['ID'];
        $nom = $dbrow ['NOM'];
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

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
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
