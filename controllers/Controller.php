<?php

/**
 * Classe abstraite qui défini la structure d'un controller.
 *
 * Class Controller
 */
abstract class Controller
{
    /**
     * Le constructeur du controller qui va automatiquement initialiser les variables et demander l'affichage.
     * (Renvoie une exception à cause de init().
     *
     * @param null $args
     * @throws Exception
     */
    public final function __construct ($args = null)
    {
        $this->init($args);
        $this->render();
    }


    /**
     * La partie initialisation que chaque controller doit implémenter (peut être vide si pas de variables nécessaire).
     * Dans cette partie on s'occupera d'initialiser les variables nécessaire, récupérer les valeurs des requêtes...
     *
     * @param mixed $args
     * @return mixed
     * @throws Exception
     */
    abstract protected function init ($args);


    /**
     * La partie affichage que chaque controller doit implémenter (si elle est vide, se poser des questions...)
     *
     * @return mixed
     */
    abstract protected function render ();
}