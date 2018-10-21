<?php

abstract class Controller
{
    # Le constructeur du controller va automatiquement initialiser les variables et demander l'affichage
    public function __construct ($args)
    {
        $this->init($args);
        $this->render();
    }

    # La partie initialisation que chaque controller doit implémenter (peut être vide si pas de variables nécessaire)
    abstract protected function init ($args);

    # La partie affichage que chaque controller doit implémenter (si elle est vide, se poser des questions...)
    abstract protected function render ();
}