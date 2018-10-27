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
        exit();
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
        <style>
        .tab { margin-left: 40px; }
        </style>
        </head>
        <body>
        <h1>Félicitations et bienvenue chez cook and burn !</h1>
        <br>
        <p>Bravo vous possédez maintenant un compte chez Cook and Burn.</p>
        <p>Vous pouvez mainteant vous connecter avec:</p>
        <p class="tab">- votre pseudo ( '. $pseudo .' ) ou email.</p>
        <p class="tab">- votre mot de passe temporaire ( '. $password .' )</p>
        <br>
        <b>Nous vous conseillons de changer votre mot de passe !</b>
        <br>
        <a href="https://projetwebcookburn.alwaysdata.net/connexion"></a>
        </body>
        </html>';

        $header = "Content-Type: text/html; charset=UTF-8\r\n";

        return mail($mail, $subject, $message, $header);
    }


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
        <style>
        .tab { margin-left: 40px; }
        </style>
        </head>
        <body>
        <h1>Votre compte chez Cook and Burn à été suprimé !</h1>
        <br>
        <b>Raison:</b>
        <p class="tab">';

        $message .= wordwrap($raison, 140, "</p>\n<p class=\"tab\">") . '</p>
        </body>
        </html>';

        $header = "Content-Type: text/html; charset=UTF-8\r\n";

        return mail($mail, $subject, $message, $header);
    }

    /**
     * Fonction de développement pour afficher de manière "jolie" le contenu d'une variable pour test/vérif/débug.
     *
     * TODO en dernier : delete la fonction
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