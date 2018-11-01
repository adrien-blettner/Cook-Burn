<?php

/**
 * Classe qui regroupe les fonctions de requêtes liées à l'admin (création, suppresion d'utilisateur ...)
 *
 * Class RequetesAdmin
 */
class RequetesAdmin
{
    /**
     * Ajoute un utilisateur à la BD et lui envoie un mail pour le prévenir de son nouveau compte et mdp.
     *
     * @param string  $pseudo      Le pseudo du nouvelle utilisateur
     * @param string  $email       Le mail de l'utilisateur.
     * @param int     $isAdmin     Valeur pour déterminer si l'utilisateur est admin.
     * @return bool|mysqli_result  Echec/Succès.
     * @throws RequeteException
     */
    public static function addUser ($pseudo, $email, $isAdmin = 0)
    {
        # Verification que le pseudo n'est pas déjà pris
        if (!RequetesUtilisateur::pseudoIsAvailable($pseudo))
            # TODO return message erreur
            return false;

        # Verification que le mail n'est pas déjà pris
        if (!RequetesUtilisateur::mailIsAvailable($email))
            # TODO return message erreur
            return false;

        # Vérifie que la variable isAdmin est bien un int valide
        if (is_bool($isAdmin))
            $isAdmin = intval($isAdmin);
        if (!is_int($isAdmin) or !in_array($isAdmin, [0,1]))
            $isAdmin = 0;

        # Créer le mot de passe aléatoire -> même l'admin ne le connait pas
        $password = Tools::randomPassword(12);
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $requete = 'INSERT INTO MEMBRE (PSEUDO, EMAIL, PASSWORD, IS_ADMIN) VALUES (?,?,?,?)';
        $types = 'sssi';
        $values = [$pseudo, $email, $passwordHash, $isAdmin];

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
     * @throws RequeteException  Exception générique des requêtes sur la BD.
     */
    public static function deleteUser ($pseudo, $email)
    {
        $requete = 'DELETE FROM MEMBRE WHERE PSEUDO = ? AND EMAIL = ?';
        $types = 'ss';
        $values = [$pseudo, $email];

        $succes = Requetes::requeteSecuriseeSurBD($requete, $types, $values, true);

        return $succes;
    }

    /**
     * Renvoie la liste de tout les utilisateur du site.
     *
     * @return Utilisateur[]
     */
    public static function getAlluser ()
    {
        $requete = 'SELECT ID, PSEUDO, EMAIL FROM MEMBRE';

        $result = Requetes::requeteSimpleSurBD($requete);

        $list = [];
        while ($row = mysqli_fetch_assoc($result))
            array_push($list, new Utilisateur($row['ID'],$row['PSEUDO'], $row['EMAIL'], null));

        $result->close();
        return $list;
    }

    /**
     * Renvoie la liste de toutes les recettes.
     *
     * @return array
     * @throws RequeteException
     */
    public static function getAllRecette ()
    {
        $requete = 'SELECT ID, NOM FROM RECETTE';

        $result = Requetes::requeteSimpleSurBD($requete);

        $list = [];
        while ($row = mysqli_fetch_assoc($result))
            array_push($list, new Recette($row['ID'], null, $row['NOM'], null, null, null, null, null, null, null));

        $result->close();
        return $list;
    }
}