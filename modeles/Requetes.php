<?php

/**
 * Classe qui contient les fonctions à utiliser pour effectuer des requêtes sur la BD.
 *
 * Class Requetes
 */
class Requetes
{
    private static $connectionEcriture;
    private static $connectionLecture;
    # A voir pour stocker les prepared statement
    # private static $listPreparedStatement;


    /**
     * Renvoie la connection avec droit d'écriture
     *
     * @return mysqli La connection.
     */
    private static function getConnectionEcriture()
    {
        # Si la connection n'est pas initialisée, le faire
        if (!isset(self::$connectionEcriture))
        {
            self::$connectionEcriture = mysqli_connect('mysql-projetwebcookburn.alwaysdata.net', '167330_read', 'L@s88WQJUXJq4Xk0E');
            mysqli_select_db(self::$connectionEcriture, 'projetwebcookburn_maindatabase');
        }
        return self::$connectionEcriture;
    }


    /**
     *  Renvoie la connection sans droit d'écriture
     *
     * @return mysqli La connection.
     */
    private static function getConnectionLecture()
    {
        # Si la connection n'est pas initialisée, le faire
        if (!isset(self::$connectionLecture))
        {
            self::$connectionLecture = mysqli_connect('mysql-projetwebcookburn.alwaysdata.net', '167330_write', 'aAmZCw*hR!Mv9WkbB');
            mysqli_select_db(self::$connectionLecture, 'projetwebcookburn_maindatabase');
        }
        return self::$connectionLecture;
    }


    /**
     * Fonction filtre qui permet en lui passant un booléen de renvoyer une connection en lecture seule ou avec droit d'écriture.
     *
     * @param   bool    $ecriture  Demande le mode écriture (vrai/faux).
     * @return  mysqli             La connection à la BD.
     */
    private static function getConnection($ecriture)
    {
        if ($ecriture)
            return self::getConnectionEcriture();
        else
            return self::getConnectionLecture();
    }


    /**
     * Fonction qui va éxecuter une requête de manière sécurisée
     *
     * @param   string              $requete    La requête SQL sous la forme compatible avec le prepared statement 'SELECT x FROM y WHERE z = ?'.
     * @param   string|null         $types      Les types des $valeurs associées dans l'ordre ('i' == int, 's' == string et 'd' == float).
     * @param   null                $valeurs    Les valeurs à "bind" à la requete.
     * @param   bool                $ecriture   Spécification du besoin du mode écriture (pour un insert par exemple).
     * @return  bool|mysqli_result              Le résultat de la requête.
     * @throws  RequetteException               Exception générique des requêtes sur la BD.
     */
    public static function requeteSecuriseeSurBD ($requete, $types = null, $valeurs = null, $ecriture = false)
    {
        # S'il n'y a pas de paramètres, c'est une requete normale (sans risque injection utilisateur)
        # S'il il a un type mais pas de valeur (oou inversement) c'est qu'il y a une erreur de code et on va
        # tenter de le traiter comme une requête non securisée (si c'est pas bon on retournera false)
        if ($types === null or $valeurs === null)
            return self::requeteSimpleSurBD($requete, $ecriture);

        $connection = self::getConnection($ecriture);
        $stmt = $connection->prepare($requete);

        if ($stmt === false)
            throw new RequetteException('Preparation of statement failed.');


        if (!is_array($valeurs))
            $valeurs = array($valeurs);

        # ... -> argument unpacking
        if ($stmt->bind_param($types, ...$valeurs) === false)
            throw new RequetteException('Binding params failed.');


        if ($stmt->execute() === false)
            throw new RequetteException('Execution of request failed.');

        $resultat = $stmt->get_result();

        if ($resultat === false)
            throw new RequetteException('Getting result failed.');

        $stmt->close();
        $connection->close();

        return $resultat;
    }


    /**
     * Fonction similaire à requeteSecuriseeSurBD() sauf qu'elle ne va pas créer de prepared statement
     * Elle ne doit être utiliser qu'avec des requete fixe sans entrée utilisateur (ex: getAllRecette())
     *
     * @param  string              $requete   La requete SQL à éxécuter.
     * @param  bool                $ecriture  Spécification du besoin du mode écriture (pour un insert par exemple).
     * @return bool|mysqli_result             Le resultat ou true (si insert, update...) ou  si échec false
     */
    public static function requeteSimpleSurBD ($requete, $ecriture = false)
    {
        $connection = self::getConnection($ecriture);

        $result = mysqli_query($connection, $requete);

        # TODO NULLL
        #$connection->close();

        return $result;
    }
}