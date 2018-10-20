<?php

require 'modeles/RequettesUtilisateur.php';

class ControllerConnexion extends Controller
{
    private $pageSuivante;
    private $messageErreur;

    public function __construct($args)
    {
        # TODO parler avec damien, on pourrait faire le traitement sur la même page et renvoyer sur /profil  -> evite de devoir charger un lien intermédiaire
        # TODO vérif que $_SESSION pas déjà mis (déjà co) si oui rediriger direct vers /profil

        if (!isset($_POST['pageSuivante']))
            $this->pageSuivante = '/profil';
        else
            $this->pageSuivante = $_POST['pageSuivante'];

        if (!isset($_POST['messageErreur']))
            $this->messageErreur = null;
        else
            $this->messageErreur = $_POST['messageErreur'];

        var_dump($this->messageErreur, $this->pageSuivante);

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

    public function render()
    {
        require 'vues/vueConnexion.php';
    }
}