<?php

class Tools
{
    /**
     * Fonction qui va redirigé vers un url en utilisant la méthode POST pour transférer les données.
     *
     * https://stackoverflow.com/questions/3045097/php-redirect-and-send-data-via-post/3045155
     *
     * @param  string  $url   L'url de destination.
     * @param  array   $data  Données sous forme ($key => $value)
     */
    public static function redirectWithPostMethod ($url, $data)
    {
        ?>
        <!doctype html>
        <html>
        <head>
            <meta charset="UTF-8">
            <script>
                function fermer () {
                    document.forms["redirection"].submit();
                }
            </script>
        </head>
        <body onload="fermer();">
            <form name="redirection" method="post" action="<? echo $url; ?>">
                <?php
                    if (!is_null($data))
                        foreach ($data as $name => $value)
                            echo '<input type="hidden" name="' . $name . '" value="' . $value . '"> ';
                ?>
            </form>
        </body>
        </html>
        <?php
    }

    /**
     * Alias de redirectWithPostMethod qui redirige vers la connexion, si on souhaite avoir un utilisateur connecté.
     *
     * @param  string  $pageSuivante  La page où on sera redirigé.
     * @param  string  $message       Le message d'erreur.
     */
    public static function redirectToConnexion ($pageSuivante, $message)
    {
        $data = ['pageSuivante'=> $pageSuivante, 'messageErreur'=>$message];
        self::redirectWithPostMethod('/connexion', $data);
    }

    /**
     * Fonction qui génère un mot de passe aléatoire d'una taille donnée (8 par défaut)  (fonction utile pour l'admin pour ajouter un nouveau compte).
     *
     * @param int $lenght
     * @return string
     */
    public static function randomPassword ($lenght = 8)
    {
        $str = 'abcdefghijklmonpqrstuvwxyz0123456789-_.?';
        $pass = '';
        for ($i=0; $i < $lenght; ++$i)
            $pass .= $str[mt_rand(0,strlen($str)-1)];

        return $pass;
    }

    # TODO fix mdp en hash + html header
    /**
     * Fonction qui envoie un mail de type "création de compte".
     *
     * @param  string  $mail      Le mail du destinataire.
     * @param  string  $pseudo    Son nouveau pseudo.
     * @param  string  $password  Son mot de passe.
     * @return bool
     */
    public static function sendNewAccountMail ($mail, $pseudo, $password)
    {
        $subject = 'Votre compte cook and burn';
        $message = '
        <html>
        <head>
        <title>Création de votre compte</title>
        <style>
        h1 { text-align: center; }
        </style>
        </head>
        <body>
        <hi>Félicitations et bienvenue chez cook and burn !</hi>
        <br>
        <p>Bravo vous possédez maintenant un compte chez Cook and Burn.</p>
        <p>Vous pouvez mainteant vous connecter avec:</p>
        <p> - votre pseudo ( '. $pseudo .' ) ou email.</p>
        <p> - votre mot de passe temporaire ( '. $password .' )</p>
        <br>
        <b>Nous vous conseillons de changer votre mot de passe !</b>
        <br>
        <a href="https://projetwebcookburn.alwaysdata.net/connexion"></a>
        </body>
        </html>';

        return mail($mail, $subject, $message);
    }

    # TODO header html
    /**
     * Fonction qui envoie un mail de type "supression de compte".
     *
     * @param  string  $mail    Le mail du destinataire.
     * @param  string  $raison  La raison de la supression du compte.
     * @return bool
     */
    public static function sendRemovedAccountMail ($mail, $raison)
    {
        $subject = 'Votre compte cook and burn';
        $message = '
        <html>
        <head>
        <title>Création de votre compte</title>
        <style>
        h1 { text-align: center; }
        </style>
        </head>
        <body>
        <hi>Votre compte à été suprimé !</hi>
        <br>
        <p>Raison:</p>';

        $message .= wordwrap($raison, 70, "<br />\n") . '
        </body>
        </html>';

        return mail($mail, $subject, $message);
    }

    /**
     * Fonction de développement pour afficher de manière "jolie" le contenu d'une variable pour test/vérif/débug.
     *
     * TODO delete
     *
     * @param $var
     */
    public static function betterDump($var)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
}