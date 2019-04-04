<?php

/**
 * Classe qui contient les fonctions à utiliser pour effectuer des requêtes sur la BD.
 *
 * Class Requetes
 */
class Requetes
{
    /**
     * Connection avec droit d'écriture et de lecture sur la BD.
     * @var mysqli
     */
    private static $connectionEcriture;

    /**
     * Connection avec seulement les droits d'écriture sur la BD.
     * @var mysqli
     */
    private static $connectionLecture;

    /**
     * Renvoie la connection avec droit d'écriture
     *
     * @return mysqli La connection.
     */
    private static function getConnectionEcriture()
    {
        // Si la connection n'est pas initialisée, le faire
        if (!isset(self::$connectionEcriture))
        {
            self::$connectionEcriture = mysqli_connect('sql2.freemysqlhosting.net', 'sql2286690', 'sJ9*gR7!');
            mysqli_select_db(self::$connectionEcriture, 'sql2286690');
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
        // Si la connection n'est pas initialisée, le faire
        if (!isset(self::$connectionLecture) or self::$connectionLecture === null)
        {
            self::$connectionLecture = mysqli_connect('sql2.freemysqlhosting.net', 'sql2286690', 'sJ9*gR7!');
            mysqli_select_db(self::$connectionLecture, 'sql2286690');
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
     * @param   string              $types      Les types des $valeurs associées dans l'ordre ('i' == int, 's' == string et 'd' == float).
     * @param   null                $valeurs    Les valeurs à "bind" à la requete.
     * @param   bool                $ecriture   Spécification du besoin du mode écriture (pour un insert par exemple).
     * @return  bool|mysqli_result              Le résultat de la requête ou vrai si MàJ ou faux si échec.
     * @throws  RequeteException               Exception générique des requêtes sur la BD.
     */
    public static function requeteSecuriseeSurBD ($requete, $types = null, $valeurs = null, $ecriture = false, &$returnID = null)
    {
        /* Vérification que le droit d'écriture est bien demandé si on à un requête qui modifie des données.
         *
         * Note 1 : cette fonction ne doit pas remplacer un appel correct de la fonction avec le droit d'écriture correspondant à la requête.
         * note 2 : De plus la vérification est sensible à la casse: si la requête commence par un espace ça ne marchera pas
         */
        if ($ecriture == false)
            foreach (['UPDATE, INSERT, DELETE'] as $needle)
                if (strpos(strtoupper($requete), $needle) === 0)
                    $ecriture = true;

        $connection = self::getConnection($ecriture);

        if (false === $stmt = $connection->prepare($requete))
            throw new RequeteException('Preparation of statement failed.');

        if (!is_array($valeurs))
            $valeurs = array($valeurs);

        // ... -> argument unpacking
        if ($stmt->bind_param($types, ...$valeurs) === false)
            throw new RequeteException('Binding params failed.');


        if ($stmt->execute() === false)
            throw new RequeteException('Execution of request failed.');

        $resultat = false;

        // On test si la requête est une MàJ (update,insert..) qui à réussi.
        // un MàJ peut ne pas échouer mais avoir un WHERE qui ne correspond à personne et donc affected_rows == 0
        if ($stmt->affected_rows > 0)
        {
            $resultat = true;
            if ($returnID !== null)
                $returnID = mysqli_insert_id($connection);
        }
        // Partie si on a un select réussi.
        else
        {
            if (false === $resultat = $stmt->get_result())
                throw new RequeteException('Getting result failed.');
        }

        $stmt->close();

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

        return $result;
    }
}
