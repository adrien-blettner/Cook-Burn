<?php

require_once 'classes/ConnectionLectureSeul.php';

# cheatSheet : http://php.net/manual/fr/mysqli-stmt.bind-param.php#parameter

class RequettesRecette
{
    # Renvoie la recette qui correspond à l'id demander
    static function getRecetteById ($id)
    {
        $lienBD = ConnectionLectureSeul::getConnection();
        assert ($lienBD instanceof mysqli, 'Erreur de connection.');
        $preparedStatement = $lienBD->prepare('SELECT * FROM RECETTE WHERE ID = ?');
        $preparedStatement->bind_param('i',$id);
        $preparedStatement->execute();
        $result = $preparedStatement->get_result();
        if (is_bool($result))
            return false;

        return Recette::FromDBRow (mysqli_fetch_assoc($result));
    }

    # Renvoie la recette du moment (dernière recette qui a atteint les 15 burn)
    static function getRecetteDuMoment ()
    {
        $lienBD = ConnectionLectureSeul::getConnection();
        assert ($lienBD instanceof mysqli, 'Erreur de connection.');
        $result = mysqli_fetch_assoc(mysqli_query($lienBD, 'SELECT * FROM RECETTE WHERE BURN = 15 ORDER BY LAST_BURN_UPDATE'));

        $recette = Recette::FromDbRow ($result);

        # Si la recette n'est pas vide on la renvoie
        if ($recette != Recette::$recetteVide)
            return $recette;

        # Si la requête précédente ne renvoie rien on tente d'obtenir la recette qui à été liké le plus réccement et avec + de 15 burns
        $result = mysqli_fetch_assoc(mysqli_query($lienBD, 'SELECT * FROM RECETTE WHERE BURN > 15 ORDER BY LAST_BURN_UPDATE'));

        # Renvoie la recette ou faux si elle est vide
        $recette = Recette::FromDbRow ($result);
        if ($recette == Recette::$recetteVide)
            return false;

        return $recette;
    }
}