<?php

/**
 * # TODO
 *
 * Class RequettesAdmin
 */
class RequettesAdmin
{
    /**
     * Ajoute un utilisateur à la BD et lui envoie un mail pour le prévenir de son nouveau compte et mdp.
     *
     * @param string  $pseudo           # TODO
     * @param string  $email        # TODO
     * @param int     $isAdmin     # TODO
     * @return bool|mysqli_result  Echec/Succès.
     * @throws RequetteException
     */
    public static function addUser ($pseudo, $email, $isAdmin = 0)
    {
        # Verification que le pseudo n'est pas déjà pris
        if (!RequettesUtilisateur::pseudoIsAvailable($pseudo))
            # TODO return message erreur
            return false;

        # Verification que le mail n'est pas déjà pris
        if (!RequettesUtilisateur::mailIsAvailable($email))
            # TODO return message erreur
            return false;

        # Vérifie que la variable isAdmin est bien un int valide
        if (is_bool($isAdmin))
            $isAdmin = intval($isAdmin);
        if (!is_int($isAdmin) or !in_array($isAdmin, [0,1]))
            $isAdmin = 0;

        # Créer le mot de passe aléatoire -> même l'admin ne le connait pas
        $password = Tools::randomPassword(12);
        $password = password_hash($password, PASSWORD_BCRYPT);

        $requete = 'INSERT INTO MEMBRE (PSEUDO, EMAIL, PASSWORD, IS_ADMIN) VALUES (?,?,?,?)';
        $types = 'sssi';
        $values = [$pseudo, $email, $password, $isAdmin];

        $succes = Requetes::requeteSecuriseeSurBD($requete, $types, $values, true);

        Tools::sendNewAccountMail($email, $pseudo, $password);

        return $succes;
    }


    /**
     * Supprime le membre lié à ce pseudo et email puis, envoie un mail pour le prévenir en donnant un motif de suppression.
     *
     * @param string  $pseudo     le pseudo de l'utilisateur.
     * @param string  $email      Le mail de l'utilisateur.
     * @param string  $raison     Raison de la suppression du compte.
     * @return bool               Echec/succès.
     * @throws RequetteException  Exception générique des requêtes sur la BD.
     */
    public static function deleteUser ($pseudo, $email, $raison)
    {
        $requete = 'DELETE FROM MEMBER WHERE PSEUDO = ? AND EMAIL = ?';
        $types = 'ss';
        $values = [$pseudo, $email];

        $succes = Requetes::requeteSecuriseeSurBD($requete, $types, $values, true);

        Tools::sendRemovedAccountMail($email, $raison);

        return $succes;
    }
}