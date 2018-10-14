<?php

require_once 'ConnectionLectureSeul.php';

class RequetteUtilisateur
{
    static function canConnect ($user, $pass)
    {
        $lienBD = ConnectionLectureSeul::getConnection();
        assert ($lienBD instanceof mysqli);
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
        if (is_string('todo'))
        {

        }

        if (is_bool($resultMail) and is_bool($resultPseudo))
            return Utilisateur::$utilisateurNull;

        if (!is_bool($resultMail))
            return Utilisateur::FromDbRow(mysqli_fetch_assoc($resultMail));
        if (!is_bool($resultPseudo))
            return Utilisateur::FromDbRow(mysqli_fetch_assoc($resultPseudo));
    }
}