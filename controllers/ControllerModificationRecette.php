<?php

class TimeToQuitException extends Exception {}

class ControllerModificationRecette extends Controller
{
    const MISSING_DATAS_ERROR = 'Veuillez à bien remplir tout les champs';
    const VALID_POST_DATAS = ['nom', 'nbConvives', 'descCourte', 'descLongue', 'etapes', 'ingredients'];
    const INVALID_METHOD_ERROR = 'Méthode utiliser pour charger la page invalide, impossible d\'éditer ou créer la recette veuillez quitter et recommencer.';
    const IMAGE_ERROR = 'Votre image est invalide, vérifier son format et sa taille (20 mo max).'. PHP_EOL . 'Si le problème persiste contacté un administateur.';

    private $messageErreur = null;
    private $currentRecette;
    private $allDataAreSet = true;
    private $imageUrl = null;


    /**
     * Fonction qui va vérifier que toutes les données nécessaire sont bien passées en paramètres, et qui convertie les caractères spéciaux en leur valeur html.
     */
    private function sanitizeAndVerifPostDatas ($args)
    {
        // Pour chaque clé de donnée post valide
        foreach (self::VALID_POST_DATAS as $name)
        {
            // Si elle existe, la "nettoyer"
            if (isset($_POST[$name]) and !strlen($_POST['$name']))
                $this->sanitize($_POST[$name]);
            // Sinon on met la variable "allDataAreSet" à faux, car toute les données n'existe ne sont pas rentrées..
            else
            {
                // On met à null pour pouvoir l'utiliser plus tard, dans saveDatasToRender() sans se poser de questions (valeur null autorisées).
                $_POST[$name] = null;
                $this->allDataAreSet = false;
            }
        }

        // Si l'image de la recette n'as pas été upload, on met "allDataAreSet" à faux.
        if ($args != 'editer' and (!isset ($_FILES['photo']) or $_FILES['photo']['size'] == 0))
            $this->allDataAreSet = false;
    }

    /**
     * Prend une variable et la "nettoie" de tout caractères spéciaux.
     * @param $var
     */
    private function sanitize (&$var)
    {
        // Si la variable n'est pas un array, on la néttoie.
        if (!is_array($var))
            $var = htmlspecialchars($var, ENT_QUOTES, 'UTF-8');
        // Sinon si c'est une liste on la néttoie, de manière récursive si l'élément dans la liste est lui aussi une liste.
        else
            foreach ($var as $ellement)
                $this->sanitize($ellement);
    }

    /**
     * fonction qui upload l'image sur IMGUR et récupère l'adresse de l'image via l'api du site.
     *
     * @return string URL de l'image.
     */
    private function getImageUrl ()
    {
        $client_id = 'a95e8c78490ed17';
        if ($_FILES['photo']['error'] !== 0 || $_FILES['photo']['size'] > 200000000000) {
            return null;
        }


        $filetype = explode('/',mime_content_type($_FILES['photo']['tmp_name']));
        if ($filetype[0] !== 'image') {
            return null;
        }

        $image = file_get_contents($_FILES['photo']['tmp_name']);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array( "Authorization: Client-ID $client_id" ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, array( 'image' => base64_encode($image) ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $reply = curl_exec($ch);

        curl_close($ch);

        $reply = json_decode($reply);

        $imagelink = $reply->data->link;

        return $imagelink;
    }

    private function formatEtapes ()
    {
        $etapes = '';
        foreach ($_POST['etapes'] as $etape)
        {
            $etapes .= $etape . '|';
        }

        return substr($etapes, 0, -1);
    }

    private function formatIngredients ()
    {
        $ingredients = '';

        foreach ($_POST['ingredients'] as $ingredient)
        {
            $ingredients .= $ingredient[0] . 'Δ' . $ingredient[1] . '|';
        }

        return substr($ingredients, 0, -1);
    }

    /**
     * Fonction appelé en cas d'erreur, elle sauvegarde le message d'erreur, les données déjà entrée et quitte l'initialisation.
     * @param string $error Le message d'erreur.
     * @throws TimeToQuitException
     */
    private function saveAndQuit ($error)
    {
        $this->messageErreur = $error;
        $this->saveDatasToRender();
        throw new TimeToQuitException('Time to quit');
    }

    /**
     * Fonction qui sauvegarde une recette dans $currentRecette pour pouvoir afficher les valeurs dans la page.
     * Cette fonction est appelé uniquement lors ce que l'on créer une recette, si on l'edit, on à déjà tous ses champs renseignés.
     */
    private function saveDatasToRender ()
    {
        $this->currentRecette = new Recette(null, Session::getID(), $_POST['nom'], $_POST['nbConvives'], $_POST['descCourte'], $_POST['descLongue'], $_POST['ingredients'], $this->imageUrl, $_POST['etapes'], null);
    }

    public function init($args)
    {
        $this->currentRecette = Recette::$recetteVide;

        try {
            if (isset($_POST['idEditer']))
                Session::setRecetteAEditer($_POST['idEditer']);

            // Demande la connection de l'utilisateur pour créer une recette.
            if (!Session::isConnected())
                Tools::redirectToConnexion($_GET['url'], 'Vous devez être connecté pour créer une recette.');

            // Si on demande la page '/recettes/x' et que 'x' est différent de 'editer' et 'creer', on redirige vers l'accueil.
            if (!in_array($args, ['editer', 'creer']))
                Tools::redirectToHome();

            // partie création de recette.
            if (isset($_POST['action']) and $_POST['action'] === 'Poster recette') {
                // Avant tout on élimine tout risque de présence de caractères spéciaux html.
                $this->sanitizeAndVerifPostDatas($args);

                // Vérification que toutes les données on été passées en paramètres.
                if ($this->allDataAreSet === false)
                    $this->saveAndQuit(self::MISSING_DATAS_ERROR);

                // Vérification que l'image est valide.
                if ((isset ($_FILES['photo']) or $_FILES['photo']['size'] == 0) and (null === $this->imageUrl = $this->getImageUrl() or strlen($this->imageUrl) < 5))
                    $this->saveAndQuit(self::IMAGE_ERROR);

                $recette = new Recette(Session::getRecetteAEditer(), Session::getID(), $_POST['nom'], $_POST['nbConvives'], $_POST['descCourte'], $_POST['descLongue'], $this->formatIngredients(), $this->imageUrl, $this->formatEtapes(), 0);

                // Partie mise à jour : on à éditer la recette et souhaite mettre à jour la recette avec les nouveaux paramètres.
                if ($args === 'editer' and isset($_SESSION['recetteAEditer']) and Session::getRecetteAEditer() !== null) {
                    $recetteID =Session::getRecetteAEditer();
                    Session::setRecetteAEditer(null);
                    RequetesRecette::updateRecette($recette);
                }
                // Sinon on créer un recette.
                else if ($args === 'creer') {
                    $recetteID = RequetesRecette::addRecette($recette)[1];
                }
                // Sinon on à un problème (qui devrait quand même être détécté plus tôt).
                else
                    $this->saveAndQuit(self::INVALID_METHOD_ERROR);

                // on recupère l'id de la nouvelle page et on redirige
                header('location: /recette/' . $recetteID);
                exit();
            }
            // Partie appelé si on a pas cliqué sur le bouton pour soumettre le formulaire et qu'on à demandé la page 'editer'.
            else if ($args === 'editer') {
                // Si la recette à éditer est inexistante ou null, on quitte.
                if (!isset($_SESSION['recetteAEditer']) or Session::getRecetteAEditer() === null)
                    Tools::redirectToHome();

                // Si l'utilisateur n'est ni admin ni propriétaire de la recette, on quitte.
                $recette = RequetesRecette::getRecetteById(Session::getRecetteAEditer());
                if (!Session::isAdmin() and Session::getID() != $recette->getIDCreateur())
                    Tools::redirectToConnexion('/recette/'.Session::getRecetteAEditer(), 'La recette que vous tentez d\'éditer ne vous appartient pas, reconnectez vous avec le compte propriétaire (vous avez été déconnecté)');

                // On sauvegarde les données récupérées de la recette à éditer
                $this->currentRecette = $recette;
            }
        }
        catch (TimeToQuitException $ttq) {
            // on ignore l'exception qui signifie juste que l'on doit quitter.
        }
    }

    public function render()
    {
        $messageErreur = $this->messageErreur;
        $recette = $this->currentRecette;
        require 'vues/vueCreationRecette.php';
    }
}