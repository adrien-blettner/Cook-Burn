<?php
require_once 'models/dataBaseRequest.php';
class Recette
{
    private $ID;
    private $NOM;
    private $CREATEUR;
    private $NB_CONVIVES;
    private $DESC_COURTE;
    private $DESC_LONGUE;
    private $INGREDIENTS;
    private $IMAGE_URL;
    private $ETAPES;
    private $BURN;
    private $LAST_UPDATE;

    public static $recetteVide;

    function __construct ($ID, $CREATEUR, $NOM, $NB_CONIVES, $DESCRIPTION_COURTE, $DESCRIPTION_LONGUE, $INGREDIENTS,$IMAGE_URL, $ETAPES, $BURN, $LAST_UPDATE)
    {
        $this->ID          = $ID;
        $this->CREATEUR    = $CREATEUR;
        $this->NOM         = $NOM;
        $this->NB_CONVIVES = $NB_CONIVES;
        $this->DESC_COURTE = $DESCRIPTION_COURTE;
        $this->DESC_LONGUE = $DESCRIPTION_LONGUE;
        $this->INGREDIENTS = explode ('↨', $INGREDIENTS);
        $this->IMAGE_URL   = $IMAGE_URL;
        $this->ETAPES      = explode ('↨', $ETAPES);
        $this->BURN        = $BURN;
        $this->LAST_UPDATE = $LAST_UPDATE;
    }

    static function FromDBRow ($dbRow)
    {
        if ($dbRow == null)
            return Recette::$recetteVide;
        $ID          = $dbRow ['ID'];
        // TODO getUserByID
        $CREATEUR    = $dbRow ['ID_CREATEUR'];
        $NOM         = $dbRow ['NOM'];
        $NB_CONVIVES = $dbRow ['NB_CONIVES'];
        $DESC_COURTE = $dbRow ['DESCRIPTION_COURTE'];
        $DESC_LONGUE = $dbRow ['DESCRIPTION_LONGUE'];
        $INGREDIENTS = $dbRow ['INGREDIENTS'];
        $ETAPES      = $dbRow ['ETAPES'];
        $BURN        = $dbRow ['BURN'];
        $IMAGE_URL   = $dbRow ['IMAGE_URL'];
        $LAST_UPDATE = $dbRow ['LAST_BURN_UPDATE'];
        return new Recette ($ID, $CREATEUR, $NOM, $NB_CONVIVES, $DESC_COURTE, $DESC_LONGUE, $INGREDIENTS, $IMAGE_URL, $ETAPES, $BURN, $LAST_UPDATE);
    }

    public function equals (Recette $recette)
    {
        return  $this->ID          == $recette->getID ()
            and $this->NOM         == $recette->getNOM()
            and $this->NB_CONVIVES == $recette->getNBCONVIVES()
            and $this->DESC_LONGUE == $recette->getDESCLONGUE()
            and $this->DESC_COURTE == $recette->getDESCCOURTE()
            and $this->INGREDIENTS == $recette->getINGREDIENTS()
            and $this->IMAGE_URL   == $recette->getIMAGEURL()
            and $this->ETAPES      == $recette->getETAPES()
            and $this->IMAGE_URL   == $recette->getIMAGEURL()
            and $this->BURN        == $recette->getBURN();
    }

    public function getID()
    {
        return $this->ID;
    }

    public function getNOM()
    {
        return $this->NOM;
    }

    public function getNBCONVIVES()
    {
        return $this->NB_CONVIVES;
    }

    public function getDESCCOURTE()
    {
        return $this->DESC_COURTE;
    }

    public function getDESCLONGUE()
    {
        return $this->DESC_LONGUE;
    }

    public function getINGREDIENTS()
    {
        return $this->INGREDIENTS;
    }

    public function getETAPES()
    {
        return $this->ETAPES;
    }

    public function getBURN()
    {
        return $this->BURN;
    }

    public function getIMAGEURL()
    {
        return $this->IMAGE_URL;
    }

    public function getCREATEUR()
    {
        return $this->CREATEUR;
    }

    public function getLASTUPDATE()
    {
        return $this->LAST_UPDATE;
    }

}
// Initialise la recette static vide
Recette::$recetteVide = new Recette(null, null, null,null,null,null,null,null,null,null, null);