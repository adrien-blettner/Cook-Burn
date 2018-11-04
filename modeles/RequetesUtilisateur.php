<?php

/**
 * Classe qui regroupe les requêtes liées aux actions réalisable par l'utilisateur.
 *
 * Class RequetesUtilisateur
 */
class RequetesUtilisateur
{
    /**
     * Renvoie l'utilisateur lié au pseudo/email et mot de passe, sinon renvoi un boolean == false
     *
     * @param string  $user
     * @param string  $pass
     * @return bool|Utilisateur
     * @throws RequeteException
     */
    public static function connect ($user, $pass)
    {
        $requete = 'SELECT * FROM MEMBRE WHERE PSEUDO = ?';
        $type = 's';
        $value = [$user];
        $resultPseudo = Requetes::requeteSecuriseeSurBD($requete, $type, $value);

        if (!is_bool($resultPseudo))
            $resultPseudo = mysqli_fetch_assoc($resultPseudo);

        if (!password_verify($pass, $resultPseudo['PASSWORD']))
        {
            $requete = 'SELECT * FROM MEMBRE WHERE EMAIL = ?';
            $type = 's';
            $value = [$user];
            $resultMail = Requetes::requeteSecuriseeSurBD($requete, $type, $value);

            if (!is_bool($resultMail))
                $resultMail = mysqli_fetch_assoc($resultMail);

            if (!password_verify($pass, $resultMail['PASSWORD']))
                return false;

            $utilisateur = Utilisateur::FromDbRow($resultMail);

            return $utilisateur;
        }

        $utilisateur = Utilisateur::FromDbRow($resultPseudo);

        return $utilisateur;
    }

    /**
     * Fonction qui renvoie l'utilisateur correspondant à cette ID
     *
     * @param int $id             L'id de l'utilisateur recherché.
     * @return Utilisateur        L'utilisateur correspondant ou un utilisateur vide.
     * @throws RequeteException
     */
    public static function getUserByID ($id)
    {
        $requete = 'SELECT * FROM MEMBRE WHERE ID = ?';
        $type = 'i';
        $value = [$id];
        $result = Requetes::requeteSecuriseeSurBD($requete, $type, $value);

        if ($result === false)
            return Utilisateur::$utilisateurNull;

        $utilisateur = Utilisateur::FromDbRow(mysqli_fetch_assoc($result));

        $result->close();

        return $utilisateur;
    }


    /**
     * Met à jour le pseudo du membre.
     *
     * @param int     $id         L'id du membre.
     * @param string  $newPseudo  Le nouveau pseudo.
     * @return string|bool               Echec/succès.
     * @throws RequeteException  Exception générique des requêtes sur la BD.
     */
    public static function updatePseudo ($id, $newPseudo)
    {
        if (!self::pseudoIsAvailable($newPseudo))
            return "Pseudo déjà utilisé par un autre compte !";

        $requete = 'UPDATE MEMBRE SET PSEUDO = ? WHERE ID = ?';
        $types = 'si';
        $values = [$newPseudo, $id];

        $succes = Requetes::requeteSecuriseeSurBD($requete, $types, $values, true);

        return $succes;
    }


    /**
     * Met à jour le mail du membre.
     *
     * @param int     $id         L'id du membre.
     * @param string  $newMail    Le nouveau mail.
     * @return string|bool        Echec/succès/Message d'erreur.
     * @throws RequeteException  Exception générique des requêtes sur la BD.
     */
    public static function updateEMail ($id, $newMail)
    {
        if (!self::mailIsAvailable($newMail))
            return "Email déjà utilisé par un autre compte !";

        $requete = 'UPDATE MEMBRE SET EMAIL = ? WHERE ID = ?';
        $types = 'si';
        $values = [$newMail, $id];

        $succes = Requetes::requeteSecuriseeSurBD($requete, $types, $values, true);

        return $succes;
    }


    /**
     * Met à jour le mot de passe du membre.
     *
     * @param int     $id           L'id du membre.
     * @param string  $newPassword  Le nouveau mot de passe.
     * @return bool                 Echec/succès.
     * @throws RequeteException    Exception générique des requêtes sur la BD.
     */
    public static function updatePassword ($id, $newPassword)
    {
        $requete = 'UPDATE MEMBRE SET PASSWORD = ? WHERE ID = ?';
        $types = 'si';
        $values = [password_hash($newPassword, PASSWORD_BCRYPT), $id];

        $succes = Requetes::requeteSecuriseeSurBD($requete, $types, $values, true);

        return $succes;
    }


    /**
     * Renvoie vrai si le mail est libre, faux sinon.
     *
     * @param string $mailToTest    Le pseudo à test.
     * @return bool                 Résultat.
     * @throws RequeteException    Exception générique des requêtes sur la BD.
     */
    public static function mailIsAvailable ($mailToTest)
    {
        $test = Requetes::requeteSecuriseeSurBD('SELECT ID FROM MEMBRE WHERE EMAIL = ?', 's', $mailToTest);

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
     * @throws RequeteException    Exception générique des requêtes sur la BD.
     */
    public static function pseudoIsAvailable ($pseudoToTest)
    {
        $test = Requetes::requeteSecuriseeSurBD('SELECT ID FROM MEMBRE WHERE PSEUDO = ?', 's', $pseudoToTest);

        if ($test->num_rows !=0)
            return false;

        $test->close();

        return true;
    }

    /**
     * Fonction qui créer un nouveau mot de passe et l'envoie par mail.
     *
     * @param int $id L'id de l'utilisateur.
     * @param string $mail Le mail de l'utilisateur.
     * @return bool Succès de l'opération
     * @throws RequeteException
     */
    public static function lostPassword ($mail)
    {
        // Pour vérifier que le mail existe bel et bien, on vérifie ça disponibilité: s'il est disponible (pour créer un compte) alors il n'existe pas et on quitte.
        if(self::mailIsAvailable($mail))
            return false;

        // Il faut l'id du compte qui possède ce mail.
        $requete = 'SELECT ID FROM MEMBRE WHERE EMAIL=?';
        $type = 's';
        $valeur = [$mail];

        $result = Requetes::requeteSecuriseeSurBD($requete, $type, $valeur);

        if (is_bool($result) or null === $row = mysqli_fetch_assoc($result))
            return false;

        $id = $row['ID'];
        $newPassword = Tools::randomPassword();

        if (!self::updatePassword($id, $newPassword))
            return false;

        Tools::sendLostPasswordMail($mail, $newPassword);

        return true;
    }
}