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
    public static function getRecetteById ($id)
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
     * @return Recette[]  La liste des recettes ou false.
     * @throws RequeteException
     */
    public static function getLastRecettes ()
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
    public static function getRecetteDuMoment ()
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
     * @param Recette $recette
     * @return array                       Retourne vrai si la recette a correctement été créée avec son id, faux et -1 sinon.
     * @throws RequeteException            Exception générique des requêtes sur la BD.
     */
    public static function addRecette ($recette)
    {
        $req = 'INSERT INTO RECETTE (ID_CREATEUR, NOM, NB_CONVIVES, DESCRIPTION_COURTE, DESCRIPTION_LONGUE, INGREDIENTS, ETAPES, BURN, IMAGE_URL, LAST_BURN_UPDATE) VALUES (?,?,?,?,?,?,?,?,?,?)';
        $types = 'isissssiss';
        $values = [
            $recette->getIDCreateur(),
            $recette->getNom(),
            $recette->getNbConvives(),
            $recette->getDescriptionCourte(),
            $recette->getDescriptionLongue(),
            $recette->getIngredients(),
            $recette->getEtapes(),
            0,
            $recette->getImageURL(),
            '0000-00-00'
        ];

        $id = -1;

        $succes = Requetes::requeteSecuriseeSurBD($req, $types, $values, true, $id);

        return [$succes, $id];
    }

    /**
     * Met à jour une recette
     *
     * @param Recette $recette
     * @throws RequeteException
     */
    public static function updateRecette ($recette)
    {
        $requete = 'UPDATE RECETTE SET NOM=?,NB_CONVIVES=?,DESCRIPTION_COURTE=?,DESCRIPTION_LONGUE=?,INGREDIENTS=?,ETAPES=?';
        $types = 'sissss';
        $value = [
            $recette->getNom(),
            $recette->getNbConvives(),
            $recette->getDescriptionCourte(),
            $recette->getDescriptionLongue(),
            $recette->getIngredients(),
            $recette->getEtapes()
        ];
        if ($recette->getImageURL() !== null)
        {
            $requete .= ',IMAGE_URL=?';
            $types .= 's';
            array_push($value, $recette->getImageURL());
        }
        $requete .= ' WHERE ID=?';
        $types .= 'i';
        array_push($value, $recette->getId());

        Requetes::requeteSecuriseeSurBD($requete, $types, $value, true);
    }

    /**
     * Supprime la recette correspondant à l'id.
     *
     * @param  int      $id      L'id de la recette
     * @return bool              succès ou non.
     * @throws RequeteException
     */
    public static function deleteRecette ($id)
    {
        $requete = 'DELETE FROM RECETTE WHERE ID = ?';
        $type = 'i';
        $value = [$id];

        return Requetes::requeteSecuriseeSurBD($requete, $type, $value, true);
    }

    /**
     * Fonction qui détermine si l'utilisateur à déjà like la recette ou non.
     *
     * @param  int  $idRecette  L'id de la recette.
     * @param  int  $idUser     L'id de l'utilisateur.
     * @return bool
     * @throws RequeteException
     */
    public static function haveLiked ($idRecette, $idUser)
    {
        $requete = 'SELECT * FROM BURN WHERE ID_RECETTE=? AND ID_MEMBRE=?';
        $types = 'ii';
        $values = [$idRecette, $idUser];

        $result = Requetes::requeteSecuriseeSurBD($requete, $types, $values);

        if ($result->num_rows == 0)
            return false;
        elseif (!is_bool($result))
           return true;
        else
            throw new RequeteException('erreur lors de la requette \'haveliked\'');
    }

    /**
     * Fonction qui ajoute un like sur une recette par un utilisateur donné.
     *
     * @param  int  $idRecette  L'id de la recette.
     * @param  int  $idUser     L'id de l'utilisateur.
     * @throws RequeteException
     */
    public static function addLike ($idRecette, $idUser)
    {
        $requete1 = 'UPDATE RECETTE SET BURN = BURN+1 WHERE ID=?';
        $type1 = 'i';
        $value1 = [$idRecette];

        $requete2 = 'INSERT INTO BURN (ID_RECETTE, ID_MEMBRE) VALUES (?,?)';
        $type2 = 'ii';
        $value2 = [$idRecette, $idUser];

        $success1 = Requetes::requeteSecuriseeSurBD($requete1, $type1, $value1, true);
        $success2 = Requetes::requeteSecuriseeSurBD($requete2, $type2, $value2, true);
    }
}