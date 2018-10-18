<?php
function start_page($title = 'default', $additionalParams = array())
{
    $headParameters = array (
        '<meta charset="UTF-8">',
        '<title>'.$title.'</title>'
    );

    $EOL_TAB = PHP_EOL."\t";
    echo '<!DOCTYPE html>'.PHP_EOL.'<html lang="fr">'.$EOL_TAB.'<head>' . PHP_EOL;

    echo "\t\t". '<link rel="stylesheet" type="text/css" href="/views/css/styles.css">' .PHP_EOL;

    foreach (array_merge ($headParameters, $additionalParams) as $param)
        echo "\t\t".$param.PHP_EOL;

    echo "\t" . '</head>'.$EOL_TAB.'<body>'.PHP_EOL;
};



function end_page ()
{
    echo "\t".'</body>'.PHP_EOL.'</html>';
};