<?php

require_once 'ConnectionLectureSeul.php';

# cheatSheet : http://php.net/manual/fr/mysqli-stmt.bind-param.php#parameter

class RequetteRecette
{
    static function getRecetteById ($id)
    {
        $lienBD = ConnectionLectureSeul::getConnection();
        assert ($lienBD instanceof mysqli);
        $preparedStatement = $lienBD->prepare('SELECT * FROM RECETTE WHERE ID = ?');
        $preparedStatement->bind_param('i',$id);
        $preparedStatement->execute();
        $result = $preparedStatement->get_result();
        if (is_bool($result))
            return new Recette::$recetteVide;

        return Recette::FromDBRow (mysqli_fetch_assoc($result));
    }

    static function getRecetteDuMoment ()
    {
        #TODO implémenter cette fonction
        return Recette::$recetteVide;
    }
}