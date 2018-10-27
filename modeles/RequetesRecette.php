<?php

/**
 * Classes qui contient les requêtes liés aux recettes.
 *
 * Class RequetesRecette
 */
class RequetesRecette
{
    /**
     * Renvoie une recette correspondant à l'id passer en paramètre.
     *
     * @param  int                $id  L'id de la recette souhaitée.
     * @return bool|Recette            La recette demandé ou false si non trouvée.
     * @throws RequeteException       Exception générique des requêtes sur la BD.
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
     * @throws RequeteException
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
     * @throws RequeteException
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

    /**
     * Ajoute une nouvelle recette à la bdd
     *
     * @param int $idCreateur              L'id du créateur de la recette.
     * @param string $nomRecette           Le nom de la nouvelle recette.
     * @param int $nbConvives              Le nombre de convives de la recette.
     * @param string $descriptionCourte    Une description de quelques caracteres.
     * @param string $descriptionLongue    Une description plus longue.
     * @param string $ingredients          La liste des ingrédients.
     * @param string $etapes               Les étapes pour realiser la recette.
     * @param string $image                Une image et/ou photo de la recette.
     * @return bool|mysqli_result          Retourne vrai si la recette a correctement été créée.
     * @throws RequeteException           Exception générique des requêtes sur la BD.
     */
    static function setNewRecette ($idCreateur, $nomRecette, $nbConvives, $descriptionCourte, $descriptionLongue, $ingredients, $etapes, $image)
    {
        $req = 'INSERT INTO RECETTE (ID_CREATEUR, NOM, NB_CONVIVES, DESCRIPTION_COURTE, DESCRIPTION_LONGUE, INGREDIENTS, ETAPES, BURN, IMAGE_URL, LAST_BURN_UPDATE) VALUES (?,?,?,?,?,?,?,0,?,0/0/0)';
        $types = 'isisssss';
        $values = [$idCreateur, $nomRecette, $nbConvives, $descriptionCourte, $descriptionLongue, $ingredients, $etapes, $image];

        $succes = Requetes::requeteSecuriseeSurBD($req, $types, $values, true);

        return $succes;
    }
}