<?php

# Inspiration (entre autre): https://www.grafikart.fr/formations/programmation-objet-php/autoload

# On aurait pu utiliser __autoload() mais c'est découragé (et maintenant déprécié depuis php7.2)

class AutoLoader
{
    public static function register ()
    {
        spl_autoload_register(array('AutoLoader', 'customAutoload'));
    }

    public static function customAutoload ($class)
    {
        # Dossier où on peux trouver une classe
        $correctDirectories = array('classes/', 'controllers/', 'modeles/', 'Routeur/');

        foreach ($correctDirectories as $dir)
        {
            $file = $dir . $class . '.php';
            # Si la classe existeon la "require" et on quitte
            if (file_exists($file))
            {
                require_once $file;
                return;
            }
        }

        # En théorie cette fonction n'est jamais appelé sauf si quelqu'un se trompe dans le nom lors de la création d'une classe
        throw new Error('autoloading class failed');
    }
}