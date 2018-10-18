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
        if ($testPseudo->execute() === False and $testMail->execute() === False)
            return False;

        $resultMail = $testMail->get_result();
        if (!is_bool($resultMail))
            $resultMail = $resultMail->fetch_assoc();

        $resultPseudo = $testPseudo->get_result();
        if (!is_bool($resultPseudo))
            $resultPseudo = $resultPseudo->fetch_assoc();

        $testPseudo->close();
        $testMail->close ();

        #TODO test hash php
        if (!password_verify($pass, $resultMail['PASSWORD']) and !password_verify($pass, $resultPseudo['PASSWORD']))
            return false;


        if (!is_bool($resultPseudo))
        {
            $result = Utilisateur::FromDbRow($resultPseudo);
            # On met le mot de passe à '' car pas besoin et volonté de sécu
            $result->setPassword('');
            return $result;
        }

        if (!is_bool($resultMail))
        {
            $result = Utilisateur::FromDbRow($resultMail);
            # On met le mot de passe à '' car pas besoin et volonté de sécu
            $result->setPassword('');
            return $result;
        }

        # Pseudo ou mail invalide
        return false;
    }
}