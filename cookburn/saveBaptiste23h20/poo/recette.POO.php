<?php
class Recette
{
    private $ID;
    private $NOM;
    private $NB_CONVIVES;
    private $DESC_COURTE;
    private $DESC_LONGUE;
    private $INGREDIENTS;
    private $IMAGE_URL;
    private $ETAPES;
    private $BURN;

    function __construct ($ID, $NOM, $NB_CONIVES, $DESCRIPTION_COURTE, $DESCRIPTION_LONGUE, $INGREDIENTS, $ETAPES, $BURN)
    {
        $this->ID          = $ID;
        $this->NOM         = $NOM;
        $this->NB_CONVIVES = $NB_CONIVES;
        $this->DESC_COURTE = $DESCRIPTION_COURTE;
        $this->DESC_LONGUE = $DESCRIPTION_LONGUE;
        $this->INGREDIENTS = explode ('↨', $INGREDIENTS);
        $this->ETAPES      = explode ('↨', $ETAPES);
        $this->BURN        = $BURN;
    }

    static function FromDBRow ($dbRow)
    {
        $ID          = $dbRow ['ID'];
        $NOM         = $dbRow ['NOM'];
        $NB_CONVIVES = $dbRow ['NB_CONIVES'];
        $DESC_COURTE = $dbRow ['DESCRIPTION_COURTE'];
        $DESC_LONGUE = $dbRow ['DESCRIPTION_LONGUE'];
        $INGREDIENTS = $dbRow ['INGREDIENTS'];
        $ETAPES      = $dbRow ['ETAPES'];
        $BURN        = $dbRow ['BURN'];
        return new Recette ($ID, $NOM, $NB_CONVIVES, $DESC_COURTE, $DESC_LONGUE, $INGREDIENTS, $ETAPES, $BURN);
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
}