<?php

/**
 * Classes qui contient les requêttes liés aux recettes.
 *
 * Class RequettesRecette
 */
class RequettesRecette
{
    /**
     * Renvoie une recette correspondant à l'id passer en paramètre.
     *
     * @param  int                $id  L'id de la recette souhaitée.
     * @return bool|Recette            La recette demandé ou false si non trouvée.
     * @throws RequetteException       Exception générique des requêtes sur la BD.
     */
    static function getRecetteById ($id)
    {
        $result = Requetes::requeteSecuriseeSurBD('SELECT * FROM RECETTE WHERE ID = ?', 'i', $id);

        if ($result === false)
            return false;

        # TODO  deplacer après utilisation
        #$result->close();
        return Recette::FromDBRow (mysqli_fetch_assoc($result));
    }


    /**
     * Renvoie la liste des recettes de la plus récente à la plus ancienne.
     *
     * @return bool|array  La liste des recettes ou false.
     */
    static function getLastRecettes ()
    {
        $result = Requetes::requeteSimpleSurBD('SELECT * FROM RECETTE ORDER BY LAST_BURN_UPDATE DESC');

        if ($result === false)
            return false;

        $listLastRecettes = array();

        while ($row = mysqli_fetch_assoc($result))
            $listLastRecettes[] = Recette::FromDBRow ($row);

        # TODO Why null ?
        #$result->close();

        return $listLastRecettes;
    }


    /**
     * Renvoie la recette du moment (dernière recette à avoir atteint 15 burn ou sinon recette avec + de 15 burn est liké le plus réccement.
     *
     * @return bool|Recette  La recette du moment ou false.
     */
    static function getRecetteDuMoment ()
    {
        $result = Requetes::requeteSimpleSurBD('SELECT * FROM RECETTE WHERE BURN = 15 ORDER BY LAST_BURN_UPDATE DESC');
        $recette = Recette::FromDbRow (mysqli_fetch_assoc($result));
        $result->close();

        # Si la recette n'est pas vide on la renvoie
        if (!$recette->isEmpty())
            return $recette;

        # Si la requête précédente ne renvoie rien on tente d'obtenir la recette qui à été liké le plus réccement et avec + de 15 burns
        $result = Requetes::requeteSimpleSurBD( 'SELECT * FROM RECETTE WHERE BURN > 15 ORDER BY LAST_BURN_UPDATE DESC');
        $recette = Recette::FromDbRow (mysqli_fetch_assoc($result));
        $result->close();

        if (!$recette->isEmpty())
            return $recette;

        return false;
    }
}