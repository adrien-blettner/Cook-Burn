<?php
function start_page($title = 'default', $additionalParams = array())
{
    $EOL_TAB = PHP_EOL."\t";
    echo '<!DOCTYPE html>'.PHP_EOL.'<html lang="fr">'.$EOL_TAB.'<head>' . PHP_EOL;

    echo "\t\t" . '<link rel="stylesheet" type="text/css" href="/vues/css/barreNav.css">' . PHP_EOL;

    echo "\t\t" . '<meta charset="UTF-8">'    . PHP_EOL;
    // Change les "mixed content" (les requêtes non sécurisée) de http à https.
    echo "\t\t" . '<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">' . PHP_EOL;
    echo "\t\t" . '<title>'.$title.'</title>' . PHP_EOL;

    foreach ($additionalParams as $param)
        echo "\t\t".'<link rel="stylesheet" type="text/css" href="/vues/css/'.$param.'">'.PHP_EOL;

    echo "\t" . '</head>'.$EOL_TAB.'<body>' . PHP_EOL;

    require_once 'vueBarreNav.php';
};

function end_page ()
{
    echo "\t".'</body>'.PHP_EOL.'</html>';
};
