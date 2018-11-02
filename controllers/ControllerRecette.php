<?php

/**
 * Class ControllerRecette
 */
class ControllerRecette extends Controller
{
    /**
     * La recette demandée.
     * @var Recette
     */
    private $recette;

    /**
     * Booleen qui détermine si la recette à déjà été 'like' par l'utilisateur.
     * @var bool
     */
    private $alreadyLiked;

    /**
     * Booleen qui détermine si la recette à déjà été ajoutée aux favoris de l'utilisateur.
     * @var bool
     */
    private $alreadyFavorie;

    public function init ($id)
    {
        // Récupéraiton de la recette.
        $this->recette = RequetesRecette::getRecetteById($id);

        // Si la recette demandée n'est pas valide / existante, on redirige vers la liste des recettes.
        if ($id === null or $this->recette == Recette::$recetteVide)
        {
            header('location: /#conteneurRecettes');
            exit();
        }

        // Si l'utilisateur n'est pas connecté, il ne peut pas voir une recette qui a moins de 10 BURNS.
        if ($this->recette->getBurn() < 10 and !Session::isConnected())
        {
            $url = '/recette/' . $id;
            Tools::redirectToConnexion($url, 'Vous devez être connecté pour voir cette recette !');
        }

        // Détermine si l'utilisateur à like la recette et stocke le résultat.
        $this->alreadyLiked = RequetesRecette::haveLiked($id, Session::getID());

        // Détermine si l'utilisateur à ajouté la recette à ses favoris et stocke le résultat.
        $this->alreadyFavorie = RequetesFavoris::isFavorie($id, Session::getID());

        // Si on a des actions à effectuées on les exécutes.
        if (isset($_POST['action']))
        {
            if ($_POST['action'] == 'like' and !$this->alreadyLiked)
            {
                $this->alreadyLiked = true;
                RequetesRecette::addLike($id, Session::getID());
            }
            if ($_POST['action'] == 'favoris' and !$this->alreadyFavorie)
            {
                $this->alreadyFavorie = true;
                RequetesFavoris::addTofavorite($id, Session::getID());
            }
        }
    }

    function render ()
    {
        $recette = $this->recette;
        $alreadyLiked = $this->alreadyLiked;
        $alreadyFavorie = $this->alreadyFavorie;

        // Affichage de la recette valide
        require 'vues/vueRecette.php';
    }
}