<?php

class Tools
{
    # Fonction qui va redirigé vers un url avec des données post -> array($key => $value)
    public static function redirectWithPostMethod ($url, $data)
    {
        # https://stackoverflow.com/questions/3045097/php-redirect-and-send-data-via-post/3045155
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

    # Fonction qui génère un mot de passe aléatoire d'una taille donnée (8 par défaut)  (fonction utile pour l'admin pour ajouter un nouveau compte)
    public static function randomPassword ($lenght = 8)
    {
        $str = 'abcdefghijklmonpqrstuvwxyz0123456789-_.?';
        $pass = '';
        for ($i=0; $i < $lenght; ++$i)
            $pass .= $str[mt_rand(0,strlen($str)-1)];

        return $pass;
    }
}