<?php

/**
 * Classe contenant les méthodes de routage.
 *
 * source inspiration: https://www.grafikart.fr/tutoriels/php/router-628
 *
 * Class Routeur
 */
class Routeur
{
    /**
     * Liste des routes coonues par le routeur.
     * @var array
     */
    private $routes = [];
    /**
     * Liste des méthodes acceptés de manières globales. (toute autre méthode sera refusées)
     * @var array
     */
    public $methodeAcceptee;
    /**
     * L'url qui à été demander lors du chargement de la page.
     * @var string
     */
    private $url;
    /**
     * Le nombre d'instance de routeur (il ne peut y en avoir qu'une).
     * @var int
     */
    private static $nbInstance = 0;


    /**
     * Le constructeur de la classe.
     *
     * @throws RouteurException
     */
    public function __construct()
    {
        if (self::$nbInstance > 1)
            throw new RouteurException('Un routeur existe déjà !');

        // On me le nombre d'instance à 1.
        self::$nbInstance = 1;
        // L'url demander.
        $this->url = $_GET['url'];
        // La méthode utilisée pour demander l'url.
        $this->methodeAcceptee = ['GET','POST'];
    }

    /**
     * Fonction qui ajoute une route à la liste des routes.
     *
     * @param  string            $chemin    Le chemin (url) de la route
     * @param  string|array      $methode   La ou les méthode de requête autorisée(s) pour accéderà cette page. (si on ne passe que GET, on ne pourras pas accéder à la page en POST).
     * @param  callable          $fonction  La fonction à executer lors de l'appel de cette route.
     * @throws RouteurException
     */
    public function ajouterRoute ($chemin, $methode, callable $fonction)
    {
        // Si on a une list de méthode on ajoute les routes une à une
        if (is_array($methode))
        {
            foreach ($methode as $meth)
                $this->ajouterRoute($chemin, $meth, $fonction);
            return;
        }

        // Créer une 'route' qui fait correspondre un chemin et une fonction
        $route = new Route ($chemin, $fonction);

        // Ajoute la route dans le tableau de routes,
        // dans le sous tableau correspondant à la méthode de requête (GET, POST...)
        if (!in_array($methode, $this->methodeAcceptee))
            throw new RouteurException ('Méthode de requête ' . $methode . 'non accepte.');

        $this->routes[$methode][] = $route;
    }

    /**
     * Execute le routeur: on récupère la requête et on rend la page correspondant (ou une erreur 404).
     *
     * @return mixed
     * @throws RouteurException
     */
    public function run ()
    {
        // On vérifie que la méthode requête existe et est acceptée
        $methode = $_SERVER['REQUEST_METHOD'];
        if (!isset($this->routes[$methode]) or !in_array($methode, $this->methodeAcceptee))
            throw new RouteurException ('Méthode de requête ' . $methode . 'non accepte.');

        // On tente de trouver la route correspondante
        foreach ($this->routes[$methode] as $route)
        {
            if ($route->match ($this->url))
            {
                return $route->call ();
            }
        }

        // Traitement des mauvaises requêtes (page 404)
        // TODO créer vrai route et page
        if (!isset($this->routes['404']))
            $this->routes['404'] = function () { echo 'Erreur page non trouvée.';};

        return $this->routes['404']->__invoke ();
    }
}