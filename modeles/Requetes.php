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
    # TODO voir si on stock les prepared statement dans un cache pour + de vitesse ?


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
            self::$connectionEcriture = mysqli_connect('mysql-projetwebcookburn.alwaysdata.net', '167330_write', 'aAmZCw*hR!Mv9WkbB');
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
        if (!isset(self::$connectionLecture) or self::$connectionLecture === null)
        {
            self::$connectionLecture = mysqli_connect('mysql-projetwebcookburn.alwaysdata.net', '167330_read', 'L@s88WQJUXJq4Xk0E');
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
     * @return  bool|mysqli_result              Le résultat de la requête ou vrai si MàJ ou faux si échec.
     * @throws  RequeteException               Exception générique des requêtes sur la BD.
     */
    public static function requeteSecuriseeSurBD ($requete, $types = null, $valeurs = null, $ecriture = false)
    {
        # TODO vérif si c'est une bonne idée
        # Petite vérif qui va regarder si la requête commence par UPDATE, DELETE ou INSERT
        # Si c'est vrai alors on force la virable écriture à vrai car on a besoin de modifier des données dans la BD
        # Note: c'est une faible sécurité qui ne doit pas remplacer une bonne écriture du code ni penser à demandé le droit d'écriture si besoin.
        #       de plus si il y a un espace ça ne marche pas
        foreach (['UPDATE, INSERT, DELETE'] as $needle)
            if (strpos(strtoupper($requete), $needle) === 0)
                $ecriture = true;

        $connection = self::getConnection($ecriture);

        if (false === $stmt = $connection->prepare($requete))
            throw new RequeteException('Preparation of statement failed.');

        if (!is_array($valeurs))
            $valeurs = array($valeurs);

        # ... -> argument unpacking
        if ($stmt->bind_param($types, ...$valeurs) === false)
            throw new RequeteException('Binding params failed.');


        if ($stmt->execute() === false)
            throw new RequeteException('Execution of request failed.');

        $resultat = false;

        # On test si la requête est une MàJ (update,insert..) qui à réussi.
        # un MàJ peut ne pas échouer mais avoir un WHERE qui ne correspond à personne et donc affected_rows == 0
        if ($stmt->affected_rows > 0)
        {
            $resultat = true;
        }
        # Partie si on a un select réussi.
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