<?php
function start_page($title = 'default', $additionalParams = array())
{
    $EOL_TAB = PHP_EOL."\t";
    $dt = "\t\t";

    echo '<!DOCTYPE html>'.PHP_EOL.'<html lang="fr">'.$EOL_TAB.'<head>' . PHP_EOL;

    echo $dt . '<link rel="stylesheet" type="text/css" href="/vues/css/barreNav.css">' . PHP_EOL;
    echo $dt . '<link rel="stylesheet" type="text/css" href="/vues/css/goBackToTop.css">' . PHP_EOL;

    echo $dt . '<script src="/vues/scripts/goBackTopButton.js"></script>' . PHP_EOL;

    echo $dt . '<meta charset="UTF-8">'    . PHP_EOL;
    // Change les "mixed content" (les requêtes non sécurisée) de http à https.
    echo $dt . '<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">' . PHP_EOL;
    echo $dt . '<title>'.$title.'</title>' . PHP_EOL;

    foreach ($additionalParams as $param)
        echo $dt.'<link rel="stylesheet" type="text/css" href="/vues/css/'.$param.'">'.PHP_EOL;

    echo "\t" . '</head>'.$EOL_TAB.'<body>' . PHP_EOL;

    require_once 'vueBarreNav.php';
};

function end_page ()
{
    $dt = "\t\t";
    echo $dt . '<div id="goBackTop">' . PHP_EOL;
    echo "\t\t\t" . '<a onclick="topFunction();">Haut de page</a>' . PHP_EOL;
    echo $dt . '</div>' . PHP_EOL;
    echo "\t".'</body>'.PHP_EOL.'</html>';
};
?>