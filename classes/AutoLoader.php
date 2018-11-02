<?php

/**
 * C'est la classe qui possède permet d'enregistrer notre autoloader qui va require les classes à notre place.
 *
 * On aurait pu utiliser __autoload() mais c'est découragé (et maintenant déprécié depuis php7.2)
 *
 * Inspiration (entre autre): https://www.grafikart.fr/formations/programmation-objet-php/autoload
 *
 * Class AutoLoader
 */
class AutoLoader
{
    /**
     * Fonction que l'on appelle pour enregister notre autoloader.
     */
    public static function register ()
    {
        spl_autoload_register(array('AutoLoader', 'customAutoload'));
    }

    /**
     * La fonction qui se chargera de require le bon fichier.
     *
     * @param  mixed  $class  Le nom de la classe.
     */
    public static function customAutoload ($class)
    {
        // Dossiers où l'on peux trouver le fichier de cette classe.
        $correctDirectories = array('classes/', 'controllers/', 'modeles/', 'Routeur/');

        foreach ($correctDirectories as $dir)
        {
            $file = $dir . $class . '.php';
            // Si la classe existe on la "require" et on quitte.
            if (file_exists($file))
            {
                require_once $file;
                return;
            }
        }

        // En théorie cette fonction n'est jamais appelé sauf si quelqu'un se trompe dans le nom lors de la création d'une classe.
        throw new Error('autoloading class failed');
    }
}