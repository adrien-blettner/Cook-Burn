<?php

class ControllerConnexion extends Controller
{
    private $pageSuivante;
    private $messageErreur;

    protected function init ($args)
    {
        # Prépare la page suivante
        if (!isset($_POST['pageSuivante']))
            $this->pageSuivante = '/profil';
        else
            $this->pageSuivante = $_POST['pageSuivante'];

        # Si la personne est déjà connecté, rallonge la session (car action prouve activité) et redrige immédiatement
        if ($_SESSION['isConnected'] == true)
        {
            Session::extendSessionLife();
            header('location: ' . $this->pageSuivante);
        }

        # Check s'il y a un message erreur à afficher
        if (!isset($_POST['messageErreur']))
            $this->messageErreur = null;
        else
            $this->messageErreur = $_POST['messageErreur'];

        # Si il n'y a rien à faire on quitte
        if (!isset($_POST['action']))
            return;

        # Traitement de la connection
        if ($_POST['action'] == 'connexion')
        {
            # Vérification que tout les champs sont remplie
            if (!isset($_POST['Pseudo'], $_POST['Mot_de_passe']) or $_POST['Pseudo'] == "" or $_POST['Mot_de_passe'] == "")
            {
                echo
                 '<form id="test" action="/connexion" method="post">
                 <input type="hidden" name="pageSuivante" value="' . $this->pageSuivante . '"> 
                 <input type="hidden" name="messageErreur" value="Veuillez remplir tout les champs.">
                 </form>
                 <script type="text/javascript">document.getElementById("test").submit()</script>
                ';
            }

            # Tente la connection de l'utilisateur
            $utilisateur = RequettesUtilisateur::connect($_POST['Pseudo'],$_POST['Mot_de_passe']);

            # Verification que la connection a réussie
            if ($utilisateur === False)
            {
                echo
                '<form id="test" action="/connexion" method="post">
                 <input type="hidden" name="pageSuivante" value="' . $this->pageSuivante . '"> 
                 <input type="hidden" name="messageErreur" value="Pseudo ou email et/ou mot de passe invalide.">
                 </form>
                 <script type="text/javascript">document.getElementById("test").submit()</script>
                ';
            }

            # Assigne les nouvelle variable de session
            Session::connect($utilisateur->getPseudo(), intval($utilisateur->getIsAdmin()));

            # Redirige vers la page suivante
            header('location: ' . $this->pageSuivante);

        }

        # Retour à l'accueil
        elseif ($_POST['action'] == 'Retour')
            header ('location: /');
    }

    protected function render ()
    {
        require 'vues/vueConnexion.php';
    }
}