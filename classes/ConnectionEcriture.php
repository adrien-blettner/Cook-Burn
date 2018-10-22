<?php

#TODO Delete car intégrer à Requete.php

class ConnectionEcriture
{
    private static $lienBD;

    static function getConnection ()
    {
        if (!isset(ConnectionEcriture::$lienBD))
        {
            # Connection avec utilisateur sans droit d'edit
            ConnectionEcriture::$lienBD = mysqli_connect('mysql-projetwebcookburn.alwaysdata.net', '167330_write', 'aAmZCw*hR!Mv9WkbB');
            mysqli_select_db(ConnectionEcriture::$lienBD, 'projetwebcookburn_maindatabase');
        }
        return ConnectionEcriture::$lienBD;
    }
}