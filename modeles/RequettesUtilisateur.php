<?php

require_once 'classes/ConnectionLectureSeul.php';

class RequettesUtilisateur
{
    # Renvoie l'utilisateur lié au pseudo/email et mot de passe, sinon renvoi un boolean == false
    static function connect ($user, $pass)
    {
        $lienBD = ConnectionLectureSeul::getConnection();
        assert ($lienBD instanceof mysqli, 'Erreur de connection.');
        $testPseudo   = $lienBD->prepare ('SELECT * FROM MEMBRE WHERE PSEUDO = ?');
        $testMail = $lienBD->prepare ('SELECT * FROM MEMBRE WHERE EMAIL = ?');
        $testMail->bind_param('s',$user);
        $testPseudo->bind_param('s', $user);
        $testPseudo->execute();
        $testMail->execute();
        $resultMail = $testMail->get_result();
        $resultPseudo = $testPseudo->get_result();
        $testPseudo->close();
        $testMail->close ();

        #TODO test hash php
        if (!password_verify($pass, $testMail['PASSWORD']) and !password_verify($pass, $testPseudo['PASSWORD']))
        {
            echo 'password invalid';
            return false;
        }

        if (is_bool($resultMail) and is_bool($resultPseudo))
        {
            echo 'pseudo or mail invalid';
            return false;
        }

        if (!is_bool($resultMail))
            return Utilisateur::FromDbRow(mysqli_fetch_assoc($resultMail));
        if (!is_bool($resultPseudo))
            return Utilisateur::FromDbRow(mysqli_fetch_assoc($resultPseudo));
    }
}