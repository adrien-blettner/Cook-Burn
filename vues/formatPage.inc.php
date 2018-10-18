<?php
function start_page($title = 'default', $additionalParams = array())
{
    $EOL_TAB = PHP_EOL."\t";
    echo '<!DOCTYPE html>'.PHP_EOL.'<html lang="fr">'.$EOL_TAB.'<head>' . PHP_EOL;

    # TODO move style.css to Accueil et plus tard à menu
    # echo "\t\t" . '<link rel="stylesheet" type="text/css" href="/vues/css/styles.css">' . PHP_EOL;

    echo "\t\t" . '<meta charset="UTF-8">'    . PHP_EOL;
    echo "\t\t" . '<title>'.$title.'</title>' . PHP_EOL;

    foreach ($additionalParams as $param)
        echo "\t\t".'<link rel="stylesheet" type="text/css" href="/vues/css/'.$param.'">'.PHP_EOL;

    echo "\t" . '</head>'.$EOL_TAB.'<body>' . PHP_EOL;
};

function end_page ()
{
    echo "\t".'</body>'.PHP_EOL.'</html>';
};

function menu ()
{
    #TODO placer le menu içi pour le réutiliser
}