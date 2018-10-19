<?php

class Tools
{
    public static function sendPostRequest ($url, $data)
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
                        foreach ($data as $key => $value)
                            echo '<input type="hidden" name="' . $key . '" value="' . $value . '"> ';
                ?>
            </form>
        </body>
        </html>
        <?php
    }
}
?>