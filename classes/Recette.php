<?php

# TODO renommer les variables en lowerCase (pas des const)
# TODO WTF pk la description longue marche pas ??

class Recette
{
    private $id;
    private $nom;
    private $createur;
    private $nbConvives;
    private $descriptionCourte;
    private $descriptionLongue;
    private $ingredients;
    private $imageURL;
    private $etapes;
    private $burn;
    private $lastUpdate;

    public static $recetteVide;

    function __construct ($id, $createur, $nom, $nbConvives, $descriptionCourte, $descriptionLongue, $ingredients, $imageURL, $etapes, $burn, $lastUpdate)
    {
        $this->id          = $id;
        $this->createur    = $createur;
        $this->nom         = $nom;
        $this->nbConvives  = $nbConvives;
        $this->descriptionCourte = $descriptionCourte;
        $this->descriptionLongue = $descriptionLongue;
        $this->ingredients = explode ('↨', $ingredients);
        $this->imageURL    = $imageURL;
        $this->etapes      = explode ('↨', $etapes);
        $this->burn        = $burn;
        $this->lastUpdate  = $lastUpdate;
    }

    static function FromDBRow ($dbRow)
    {
        if ($dbRow == null)
            return Recette::$recetteVide;
        $id          = $dbRow ['ID'];
        // TODO getUserByID
        $createut    = $dbRow ['ID_CREATEUR'];
        $nom         = $dbRow ['NOM'];
        $nbConvives  = $dbRow ['NB_CONIVES'];
        $descriptionCourte = $dbRow ['DESCRIPTION_COURTE'];
        $descriptionLongue = $dbRow ['DESCRIPTION_LONGUE'];
        $ingredients = $dbRow ['INGREDIENTS'];
        $imageURL    = $dbRow ['IMAGE_URL'];
        $etapes      = $dbRow ['ETAPES'];
        $burn        = $dbRow ['BURN'];
        $lastUpdate  = $dbRow ['LAST_BURN_UPDATE'];
        return new Recette ($id, $createut, $nom, $nbConvives, $descriptionCourte, $descriptionLongue, $ingredients, $imageURL, $etapes, $burn, $lastUpdate);
    }

    public function isEmpty ()
    {
        return $this == self::$recetteVide;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getNbConvives()
    {
        return $this->nbConvives;
    }

    public function getDescriptionCourte()
    {
        return $this->descriptionCourte;
    }

    public function getDescriptionLongue()
    {
        return $this->descriptionLongue;
    }

    public function getIngredients()
    {
        return $this->ingredients;
    }

    public function getEtapes()
    {
        return $this->etapes;
    }

    public function getBurn()
    {
        return $this->burn;
    }

    public function getImageURL()
    {
        return $this->imageURL;
    }

    public function getCreateur()
    {
        return $this->createur;
    }

    public function getLastUdate()
    {
        return $this->lastUpdate;
    }

}
// Initialise la recette static vide
Recette::$recetteVide = new Recette(null, null, null,null,null,null,null,null,null,null, null);