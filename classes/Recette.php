<?php

# TODO WTF pk la description longue marche pas ??

/**
 * Classe qui permet de créer un objet recette contenant tout les attibuts d'une recette.
 *
 * Class Recette
 */
class Recette
{
    /**
     * L'id de la recette.
     * @var int
     */
    private $id;

    /**
     * Le nom de la recette.
     * @var string
     */
    private $nom;

    /**
     * Le nom du createur de la recette.
     * @var int
     */
    private $createur;

    /**
     * Le nombre de convives prévus.
     * @var int
     */
    private $nbConvives;

    /**
     * Une description courte de la recette.
     * @var string
     */
    private $descriptionCourte;

    /**
     * Une description longue de la recette.
     * @var string
     */
    private $descriptionLongue;

    /**
     * La liste des ingrédients nécessaires.
     * @var array
     */
    private $ingredients;

    /**
     * L'url de l'image d'illustration de la recette.
     * @var string
     */
    private $imageURL;

    /**
     * La liste des étapes nécessaires.
     * @var array
     */
    private $etapes;

    /**
     * Le nombre de burns attribués à la recette.
     * @var int
     */
    private $burn;

    public static $recetteVide;

    /**
     * Le constructeur de la classe.
     *
     * @param  int     $id                  L'id de la recette.
     * @param  int     $createur            L'id du créateur de cette recette.
     * @param  string  $nom                 Son nom.
     * @param  int     $nbConvives          Le nombre de convives.
     * @param  string  $descriptionCourte   La description courte de la recette.
     * @param  string  $descriptionLongue   La description longue de la recette.
     * @param  string  $ingredients         La liste des ingrédients sous forme d'une chaîne.
     * @param  string  $imageURL            L'url de l'image.
     * @param  string  $etapes              La liste des étapes sous forme d'une chaîne.
     * @param  int     $burn                Le nombre de burns
     */
    function __construct ($id, $createur, $nom, $nbConvives, $descriptionCourte, $descriptionLongue, $ingredients, $imageURL, $etapes, $burn)
    {
        $this->id          = $id;
        # TODO getNOM du créateur plutôt que l'id !
        $this->createur    = $createur;
        $this->nom         = $nom;
        $this->nbConvives  = $nbConvives;
        $this->descriptionCourte = $descriptionCourte;
        $this->descriptionLongue = $descriptionLongue;
        $this->ingredients = explode ('↨', $ingredients);
        $this->imageURL    = $imageURL;
        $this->etapes      = explode ('↨', $etapes);
        $this->burn        = $burn;
    }

    /**
     * Un "constructeur" alternatif, qui va directement prendre un array extrait d'un mysqli result et renvoyé une instance de recette correspondante.
     *
     * @param  array    $dbRow  L'array extrait d'un résultat d'une requête sur la table RECETTE.
     * @return Recette
     */
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
        return new Recette ($id, $createut, $nom, $nbConvives, $descriptionCourte, $descriptionLongue, $ingredients, $imageURL, $etapes, $burn);
    }

    /**
     * Test si la recette est vide, en la comparant avec la recette vide de référence.
     *
     * @return bool Vrai si la recette est vide, faux sinon.
     */
    public function isEmpty ()
    {
        return $this == self::$recetteVide;
    }

    /**
     * Renvoie l'id de la recette.
     *
     * @return  int  L'id.
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Renvoie le nom de cette recette.
     *
     * @return  string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Renvoie le nombre de convives prévu pour la recette.
     *
     * @return  int
     */
    public function getNbConvives()
    {
        return $this->nbConvives;
    }

    /**
     * Retourne la description longue.
     *
     * @return  string
     */
    public function getDescriptionCourte()
    {
        return $this->descriptionCourte;
    }

    /**
     * Retourne la description courte.
     *
     * @return  string
     */
    public function getDescriptionLongue()
    {
        return $this->descriptionLongue;
    }

    /**
     * Renvoie la liste des ingrédients nécessaires.
     *
     * @return  array
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * Renvoie les étapes pour réaliser cette recette.
     *
     * @return  array
     */
    public function getEtapes()
    {
        return $this->etapes;
    }

    /**
     * Renvoie le nombre de burn de la recette.
     *
     * @return  int
     */
    public function getBurn()
    {
        return $this->burn;
    }

    /**
     * Renvoie l'url de l'image de la recette;
     *
     * @return  string
     */
    public function getImageURL()
    {
        return $this->imageURL;
    }

    /**
     * Renvoie le nom du créateur.
     *
     * @return  string
     */
    public function getCreateur()
    {
        return $this->createur;
    }
}
// Initialise la recette static vide
Recette::$recetteVide = new Recette(null, null, null,null,null,null,null,null,null,null);