<?php

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

         $lienBD->close();

        # Pseudo ou mail invalide
        return false;
    }

    # Fonction qui premet de mettre à jour le pseudo
    public static function updatePseudo ($newPseudo)
    {
        $lienBD = ConnectionEcriture::getConnection();
        assert ($lienBD instanceof mysqli, 'Erreur de connection.');

        if (!self::pseudoIsAvailable($newPseudo))
            #TODO send error message mail already used
            return false;

        $statement = $lienBD->prepare('UPDATE MEMBRE SET PSEUDO = ?');
        $statement->bind_param('s', $newPseudo);
        $result = $statement->execute();
        $statement->close();
        $lienBD->close();

        return $result;
    }

    # Fonction qui premet de mettre à jour le mail
    public static function updateEMail ($newMail)
    {
        $lienBD = ConnectionEcriture::getConnection();
        assert ($lienBD instanceof mysqli, 'Erreur de connection.');

        if (!self::mailIsAvailable($newMail))
            #TODO send error message mail already used
            return false;

        $statement = $lienBD->prepare('UPDATE MEMBRE SET EMAIL = ?');
        $statement->bind_param('s', $newMail);
        $result = $statement->execute();
        $statement->close();
        $lienBD->close();

        return $result;
    }

    # Fonction qui premet de mettre à jour le mot de passe
    public static function updatePassword ($newPassword)
    {
        $lienBD = ConnectionEcriture::getConnection();
        assert ($lienBD instanceof mysqli, 'Erreur de connection.');

        $statement = $lienBD->prepare('UPDATE MEMBRE SET PASSWORD = ?');
        $statement->bind_param('s', password_hash($newPassword, PASSWORD_BCRYPT));
        $result = $statement->execute();
        $statement->close();
        $lienBD->close();

        return $result;
    }


    /**
     * Renvoie vrai si le mail est libre, faux sinon.
     *
     * @param string $mailToTest    Le pseudo à test.
     * @return bool                 Résultat.
     * @throws RequetteException    Exception générique des requêtes sur la BD.
     */
    public static function mailIsAvailable ($mailToTest)
    {
        $test = Requetes::requeteSecuriseeSurBD('SELECT ID FROM MEMBER WHERE EMAIL = ?', 's', $mailToTest);

        if ($test->num_rows !=0)
            return false;

        $test->close();

        return true;
    }


    /**
     * Renvoie vrai si le pseudo est libre, faux sinon.
     *
     * @param string $pseudoToTest  Le pseudo à test.
     * @return bool                 Résultat.
     * @throws RequetteException    Exception générique des requêtes sur la BD.
     */
    public static function pseudoIsAvailable ($pseudoToTest)
    {
        $test = Requetes::requeteSecuriseeSurBD('SELECT ID FROM MEMBRE WHERE PSEUDO = ?', 's', $pseudoToTest);

        if ($test->num_rows !=0)
            return false;

        $test->close();

        return true;
    }
}