<?php

# source inspiration: https://www.grafikart.fr/tutoriels/php/router-628 

class Routeur
{
    private $routes = [];
    public $methodeAcceptee;
    private $url;

    public function __construct()
    {
        # L'url demander.
        $this->url = $_GET['url'];
        # La méthode utilisée pour demander l'url.
        $this->methodeAcceptee = ['GET','POST'];
    }

    public function ajouterRoute ($chemin, $methode, $fonction)
    {
        # Si on a une list de méthode on ajoute les routes une à une
        if (is_array($methode))
        {
            foreach ($methode as $meth)
                $this->ajouterRoute($chemin, $meth, $fonction);
            return;
        }

        # Créer une 'route' qui fait correspondre un chemin et une fonction
        $route = new Route ($chemin, $fonction);

        # Ajoute la route dans le tableau de routes,
        # dans le sous tableau correspondant à la méthode de requête (GET, POST...)
        if (!in_array($methode, $this->methodeAcceptee))
            throw new RouteurException ('Méthode de requête ' . $methode . 'non accepte.');

        $this->routes[$methode][] = $route;
    }

    public function run ()
    {
        # On vérifie que la méthode requête existe et est acceptée
        $methode = $_SERVER['REQUEST_METHOD'];
        if (!isset($this->routes[$methode]) or !in_array($methode, $this->methodeAcceptee))
            throw new RouteurException ('Méthode de requête ' . $methode . 'non accepte.');

        # On tente de trouver la route correspondante
        foreach ($this->routes[$methode] as $route)
        {
            if ($route->match ($this->url))
            {
                return $route->call ();
            }
        }

        # Traitement des mauvaises requêtes (page 404)
        if (!isset($this->routes['404']))
            $this->routes['404'] = function () { echo 'Erreur page non trouvée.';};

        return $this->routes['404']->__invoke ();
    }

    # TODO supprimer cette fonction de debug
    public function getRoutes ()
    {
        echo '<pre>';
        var_dump($this->routes);
        echo '</pre>';
    }
}