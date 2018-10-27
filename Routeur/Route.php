<?php

/**
 * Classe qui permet de créer une route contenant l'url de destination de la route et la fonction à appeller.
 *
 * Class Route
 */
class Route
{
    /**
     * L'url de destination.
     * @var string
     */
    private $url;
    /**
     * La fonction lié à cette route
     * @var callable
     */
    private $fonction;
    /**
     * Liste des arguments passés en get.
     * @var array
     */
    private $correspondances;

    /**
     * Constructeur de la classe
     *
     * @param  string    $url       L'url de destination lié à la route
     * @param  callable  $fonction  La fonction a appeller quand on demande cette route.
     */
    public function __construct($url, callable $fonction)
    {
        $this->url = trim ($url, '/');
        $this->fonction = $fonction;
    }

    /**
     * Test si l'url passer en paramètres correspond à l'url de cette route.
     *
     * @param  string  $url  L'url à tester.
     * @return bool
     */
    public function match ($url)
    {
        $url = trim ($url, '/');
        $chemin = preg_replace('#:([\w]+)#', '([^/]+)', $this->url);
        $regex = "#^$chemin$#i";

        if (!preg_match($regex, $url, $correspondances))
            return false;

        array_shift($correspondances);
        $this->correspondances = $correspondances;
        return true;
    }

    /**
     * Fonction qui appelle la fonction de cette route.
     *
     * @return mixed
     */
    public function call ()
    {
        return call_user_func_array($this->fonction, $this->correspondances);
    }
}