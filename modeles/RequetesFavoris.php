<?php

/**
 * Classes qui contient les requêtes liés aux favoris.
 *
 * Class RequetesRecette
 */
class RequetesFavoris
{
    /**
     * Fonction qui renvoie toutes les recettes favories de l'utilisateur.
     *
     * @param  int  $idUser  L'id de l'utilisateur
     * @return Recette[]
     * @throws RequeteException
     */
    public static function getAllRecetteFavorie ($idUser)
    {
        $requete = 'SELECT ID_RECETTE FROM FAVORIS WHERE ID_MEMBRE=?';
        $type = 'i';
        $value = [$idUser];

        $result = Requetes::requeteSecuriseeSurBD($requete, $type, $value);

        $favoris = [];

        while ($row = mysqli_fetch_assoc($result))
            array_push($favoris, RequetesRecette::getRecetteById($row['ID_RECETTE']));

        return $favoris;
    }

    /**
     * Fonction qui détermine si la recette fait partie des favoris de l'utilisateur.
     *
     * @param  int  $idRecette  L'id de la recette.
     * @param  int  $idUser     L'id de l'utilisateur.
     * @return bool|mysqli_result
     * @throws RequeteException
     */
    public static function isFavorie ($idRecette, $idUser)
    {
        $requete = 'SELECT ID_MEMBRE FROM FAVORIS WHERE ID_MEMBRE=? AND ID_RECETTE=?';
        $types ='ii';
        $values = [$idUser, $idRecette];

        $result = Requetes::requeteSecuriseeSurBD($requete, $types, $values);

        if ($result->num_rows == 0)
            return false;
        elseif (!is_bool($result))
            return true;
        else
            throw new RequeteException('erreur lors de la requette \'isFavorite\'');
    }

    /**
     * Ajoute une recette au favoris d'un utilisateur
     *
     * @param  int $idRecette   l'id de la recette.
     * @param  int  $idUser     L'id de l'utilisateur.
     * @throws RequeteException
     */
    public static function addTofavorite ($idRecette, $idUser)
    {
        $requete = 'INSERT INTO FAVORIS (ID_MEMBRE, ID_RECETTE) VALUES (?,?)';
        $types = 'ii';
        $values = [$idUser, $idRecette];

        Requetes::requeteSecuriseeSurBD($requete, $types, $values, true);
    }

    /**
     * Supprime une recette des favoris de l'utilisateur.
     *
     * @param  int $idRecette   l'id de la recette.
     * @param  int  $idUser     L'id de l'utilisateur.
     * @throws RequeteException
     */
    public static function removeFromFavorite ($idRecette, $idUser)
    {
        $requete = 'DELETE FROM FAVORIS WHERE ID_MEMBRE=? AND ID_RECETTE=?';
        $types = 'ii';
        $values = [$idUser, $idRecette];

        Requetes::requeteSecuriseeSurBD($requete, $types, $values, true);
    }

}