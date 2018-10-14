<?php

class ConnectionLectureSeul
{
    private static $lienBD;
        
    static function getConnection ()
    {
        if (!isset(ConnectionLectureSeul::$lienBD))
        {
            # Connection avec utilisateur sans droit d'edit
            ConnectionLectureSeul::$lienBD = mysqli_connect('mysql-projetwebcookburn.alwaysdata.net', '167330_read', 'L@s88WQJUXJq4Xk0E');
            mysqli_select_db(ConnectionLectureSeul::$lienBD, 'projetwebcookburn_maindatabase');
        }
        return ConnectionLectureSeul::$lienBD;
    }
}