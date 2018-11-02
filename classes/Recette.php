<?php

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
     * @var string
     */
    private $createur;

    /**
     * L'id du createur de la recette.
     * @var int
     */
    private $idCreateur;

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
     * La liste des ingrédients nécessaires sous forme de chaîne.
     * @var string
     */
    private $ingredients;

    /**
     * L'url de l'image d'illustration de la recette.
     * @var string
     */
    private $imageURL;

    /**
     * La liste des étapes nécessaires sous forme de chaîne.
     * @var string
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
     * @param  int     $idCreateur            L'id du créateur de cette recette.
     * @param  string  $nom                 Son nom.
     * @param  int     $nbConvives          Le nombre de convives.
     * @param  string  $descriptionCourte   La description courte de la recette.
     * @param  string  $descriptionLongue   La description longue de la recette.
     * @param  string  $ingredients         La liste des ingrédients sous forme d'une chaîne.
     * @param  string  $imageURL            L'url de l'image.
     * @param  string  $etapes              La liste des étapes sous forme d'une chaîne.
     * @param  int     $burn                Le nombre de burns
     * @throws RequeteException
     */
    function __construct ($id, $idCreateur, $nom, $nbConvives, $descriptionCourte, $descriptionLongue, $ingredients, $imageURL, $etapes, $burn)
    {
        $this->id = $id;
        // On obtient le nom de l'utilisateur par son id.
        if ($idCreateur === null) {
            $this->createur = null;
            $this->idCreateur = null;
        } else
        {
            $this->createur = RequetesUtilisateur::getUserByID($idCreateur)->getPseudo();
            $this->idCreateur = $idCreateur;
        }
        $this->nom         = $nom;
        $this->nbConvives  = $nbConvives;
        $this->descriptionCourte = $descriptionCourte;
        $this->descriptionLongue = $descriptionLongue;

        if (!is_string($ingredients))
            $this->ingredients = $this->formatIngredientsToString($ingredients);
        else
            $this->ingredients = $ingredients;

        if (!is_string($etapes))
            $this->etapes = $this->formatEtapeToString($etapes);
        else
            $this->etapes = $etapes;

        $this->imageURL    = $imageURL;
        $this->burn = $burn;
    }

    /**
     * Un "constructeur" alternatif, qui va directement prendre un array extrait d'un mysqli result et renvoyé une instance de recette correspondante.
     *
     * @param  array    $dbRow  L'array extrait d'un résultat d'une requête sur la table RECETTE.
     * @return Recette
     * @throws RequeteException
     */
    static function FromDBRow ($dbRow)
    {
        if ($dbRow == null)
            return Recette::$recetteVide;
        $id          = $dbRow ['ID'];
        $idCreateur    = $dbRow ['ID_CREATEUR'];
        $nom         = $dbRow ['NOM'];
        $nbConvives  = $dbRow ['NB_CONVIVES'];
        $descriptionCourte = $dbRow ['DESCRIPTION_COURTE'];
        $descriptionLongue = $dbRow ['DESCRIPTION_LONGUE'];
        $ingredients = $dbRow ['INGREDIENTS'];
        $imageURL    = $dbRow ['IMAGE_URL'];
        $etapes      = $dbRow ['ETAPES'];
        $burn        = $dbRow ['BURN'];
        return new Recette ($id, $idCreateur, $nom, $nbConvives, $descriptionCourte, $descriptionLongue, $ingredients, $imageURL, $etapes, $burn);
    }

    /**
     * Fonction qui prend une liste d'étapes issue d'un formulaire de creation/édition de recette et le format en string.
     *
     * @param   null|array  $etapes  La liste des ingredients.
     * @return  bool|null|string          La chaine formatée (FALSE si une erreur survient ou une chaine vide, ou null si $ingredients null)
     */
    private function formatEtapeToString ($etapes)
    {
        if ($etapes === null)
            return null;

        $result = "";
        foreach ($etapes as $etape) {
            $etape = htmlspecialchars($etape, ENT_QUOTES, 'UTF-8');
            $etape = str_replace('|', '', $etape);
            $result .= $etape . '|';
        }
        return substr($result, 0, -1);
    }

    /**
     * Fonction qui prend une liste d'ingrédients issue d'un formulaire de creation/édition de recette et le format en string.
     *
     * @param   null|array  $ingredients  La liste des ingredients.
     * @return  bool|null|string          La chaine formatée (FALSE si une erreur survient ou une chaine vide, ou null si $ingredients null)
     */
    private function formatIngredientsToString ($ingredients)
    {
        if ($ingredients === null)
            return null;

        $result = "";
        foreach ($ingredients as $arr) {
            $arr[0] = htmlspecialchars($arr[0], ENT_QUOTES, 'UTF-8');
            $arr[1] = htmlspecialchars($arr[1], ENT_QUOTES, 'UTF-8');
            $arr[0] = str_replace('|', '', $arr[0]);
            $arr[0] = str_replace('Δ', '', $arr[0]);
            $arr[1] = str_replace('|', '', $arr[1]);
            $arr[1] = str_replace('Δ', '', $arr[1]);
            $result .= $arr[0] . 'Δ' . $arr[1] . '|';
        }
        return substr($result, 0, -1);
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
     * @return  string
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * Renvoie les étapes pour réaliser cette recette.
     *
     * @return  string
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

    /**
     * Renvoie l'id du créateur.
     *
     * @return  string
     */
    public function getIDCreateur()
    {
        return $this->idCreateur;
    }
}
// Initialise la recette static vide.
// On ignore l'exception car on passe des variables null et on sait que la requette ne sera pas éxécutée.
Recette::$recetteVide = new Recette(null, null, null,null,null,null,null,null,null,null);