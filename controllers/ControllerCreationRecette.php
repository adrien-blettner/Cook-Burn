<?php

class ControllerCreationRecette extends Controller
{
    public function init ($id)
    {
        if (!isset($_SESSION['isConnected']) or $_SESSION['isConnected'] === false)
            Tools::redirectToConnexion($_GET['url'], 'Vous devez être connecté pour accéder à votre profil.');

        Tools::betterDump($_POST);


        if (isset($_POST['action']) && $_POST['action'] == 'Poster recette')
        {
            $result = [];
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'ingredient') === 0) {
                    $result[] = str_replace('|','',$value);
                }
            }
            $ingredients = "";
            foreach ($result as $arr) {
                $ingredients .= $arr[0] . "Δ" . $arr[1] . "|";
            }
            $ingredients = substr($ingredients, 0, -1);
            
            /*$client_id = 'a95e8c78490ed17';
            if ($_FILES['image']['error'] !== 0 || $_FILES['image']['size'] > 200000000000) {
                exit;
            }


            $filetype = explode('/',mime_content_type($_FILES['image']['tmp_name']));
            if ($filetype[0] !== 'image') {
                die('Invalid image type');
            }

            $image = file_get_contents($_FILES['image']['tmp_name']);

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
            $idCreateur = $_SESSION['id'];
            $nomRecette = htmlspecialchars($_POST['nomRecette'], ENT_QUOTES, 'UTF-8');
            $nbConvives = htmlspecialchars($_POST['nbConvives'], ENT_QUOTES, 'UTF-8');
            $descriptionCourte = htmlspecialchars($_POST['descriptionCourte'], ENT_QUOTES, 'UTF-8');
            $descriptionLongue = htmlspecialchars($_POST['descriptionLongue'], ENT_QUOTES, 'UTF-8');
            $ingredients = htmlspecialchars($_POST['ingredients'], ENT_QUOTES, 'UTF-8');
            $etapes = htmlspecialchars($_POST['etapes'], ENT_QUOTES, 'UTF-8');*/
            
        }
    }

    function render ()
    {
        require 'vues/vueCreationRecette.php';
    }
}