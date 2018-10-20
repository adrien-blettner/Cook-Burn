<?php

require_once 'classes/ConnectionEcriture.php';

class RequettesAdmin
{
    # Ajouter un utilisateur à la bd
    public static function addUser ($pseudo, $email, $isAdmin = 0)
    {
        $lienBD = ConnectionLectureSeul::getConnection();
        assert ($lienBD instanceof mysqli, 'Erreur de connection.');

        # Verification que le pseudo n'est pas déjà pris
        $test = $lienBD->prepare('SELECT ID FROM MEMBRE WHERE PSEUDO = ?');
        $test->bind_param('s', $pseudo);
        $test->execute();
        $test->store_result();
        # TODO return message erreur
        # On test si il y a un pseudo si on en a pas 0 c'est que le pseudo est déjà pris
        if ($test->num_rows !=0)
            return;
        $test->close();

        # Verification que le mail n'est pas déjà pris
        $test = $lienBD->prepare('SELECT ID FROM MEMBER WHERE EMAIL = ?');
        $test->bind_param('s', $email);
        $test->execute();
        $test->store_result();
        # TODO return message erreur
        # On test si il y a un mail si on en a pas 0 c'est que le mail est déjà pris
        if ($test->num_rows !=0)
            return;
        $test->close();

        $lienBD->close();


        # Vérifie que la variable isAdmin est bien un int valide
        if (is_bool($isAdmin))
            $isAdmin = intval($isAdmin);
        if (!is_int($isAdmin) or !in_array($isAdmin, [0,1]))
            $isAdmin = 0;

        # Créer le mot de passe aléatoire -> même l'admin ne le connait pas
        $password = Tools::randomPassword(12);


        # Ajoute le nouveau membre
        $lienBD = ConnectionEcriture::getConnection();
        assert ($lienBD instanceof mysqli, 'Erreur de connection.');

        # Désactive autocommit pour éviter de forcer l'insertion si le mail fail ou autre
        $lienBD->autocommit(false);

        $insert = $lienBD->prepare ('INSERT INTO MEMBRE (PSEUDO, EMAIL, PASSWORD, IS_ADMIN) VALUES (?,?,?,?)');
        $insert->bind_param ('sssi',$pseudo, $email, password_hash($password, PASSWORD_BCRYPT, $isAdmin));
        $insert->execute();

        # Si l'insertion ou le mail échoue on rollback -> annulation de l'insertion
        if (!$lienBD->commit() or !Tools::sendNewAccountMail($email, $pseudo, $password))
            $lienBD->rollback();

        $lienBD->autocommit(true);
    }

    # Fonction qui supprime un compte utilisateur
    public static function deleteUser ($pseudo, $email, $raison)
    {
        $lienBD = ConnectionLectureSeul::getConnection();
        assert ($lienBD instanceof mysqli, 'Erreur de connection.');

        # Verification que le pseudo n'est pas déjà pris
        $test = $lienBD->prepare('SELECT ID FROM MEMBRE WHERE PSEUDO = ?');
        $test->bind_param('s', $pseudo);
        $test->execute();
        $test->store_result();
        # TODO return message erreur
        # On test si il y a un pseudo si on en a pas 0 c'est que le pseudo est déjà pris
        if ($test->num_rows !=0)
            return;
        $test->close();

        # Verification que le mail n'est pas déjà pris
        $test = $lienBD->prepare('SELECT ID FROM MEMBER WHERE EMAIL = ?');
        $test->bind_param('s', $email);
        $test->execute();
        $test->store_result();
        # TODO return message erreur
        # On test si il y a un mail si on en a pas 0 c'est que le mail est déjà pris
        if ($test->num_rows !=0)
            return;
        $test->close();

        $lienBD->close();


        # Créer le mot de passe aléatoire -> même l'admin ne le connait pas
        $password = Tools::randomPassword(12);


        # Ajoute le nouveau membre
        $lienBD = ConnectionEcriture::getConnection();
        assert ($lienBD instanceof mysqli, 'Erreur de connection.');

        # Désactive autocommit pour éviter de forcer l'insertion si le mail fail ou autre
        $lienBD->autocommit(false);

        $delete = $lienBD->prepare ('DELETE FROM MEMBER WHERE PSEUDO = ? AND EMAIL = ?');
        $delete->bind_param ('ss', $pseudo, $email);
        $delete->execute();

        # Si l'insertion ou le mail échoue on rollback -> annulation de l'insertion
        if (!$lienBD->commit() or !Tools::sendRemovedAccountMail($email, $raison))
            $lienBD->rollback();

        $lienBD->autocommit(true);
    }

    # Fonction qui change le pseudo
    public static function changePseudo ()
    {

    }

    # Fonction qui change le mail
    public static function changeEMail ()
    {

    }
}