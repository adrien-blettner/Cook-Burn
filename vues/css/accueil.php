<?php
header('content-type: text/css');
?>

body {
    margin: 0;
    padding: 0;
    width: 100%;
    font-family: sans-serif;
    font-style: normal;
    font-weight: 300;
    font-size: 18px;
}

h1{
    font-size: 35px;
}

/* Création d'une banniere dynamique avec photos */
/* Configuration de l'animation */
#banniereImg{
    margin: 0 auto 0;
    height: 520px;
    border: solid black 2px;
    background-image: url("../images/test4Banniere.jpg");

    /* utilisation des prefixe -webkit- et -moz- par soucis de compatibilité */
    -webkit-animation-name: banniere1;
    -webkit-animation-duration: 12s;
    -webkit-animation-timing-function: linear;
    -webkit-animation-iteration-count: infinite;
    -webkit-animation-direction: normal;

    -moz-animation-name: banniere1;
    -moz-animation-duration: 12s;
    -moz-animation-timing-function: linear;
    -moz-animation-iteration-count: infinite;
    -moz-animation-direction: normal;

    animation-name: banniere1;
    animation-duration: 12s;
    animation-timing-function: linear;
    animation-iteration-count: infinite;
    animation-direction: normal;
}

/* Images utilisées dans l'animation avec ordre de passage */
@-webkit-keyframes banniere1 {
    0%{background-image: url("../images/test4Banniere.jpg");}
    33%{background-image: url("../images/test5Banniere.jpg");}
    66%{background-image: url("../images/test6Banniere.jpg");}
}

@-moz-keyframes banniere1 {
    0%{background-image: url("../images/test4Banniere.jpg");}
    33%{background-image: url("../images/test5Banniere.jpg");}
    66%{background-image: url("../images/test6Banniere.jpg");}
}

@keyframes banniere1 {
    0%{background-image: url("../images/test4Banniere.jpg");}
    33%{background-image: url("../images/test5Banniere.jpg");}
    66%{background-image: url("../images/test6Banniere.jpg");}
}

#description{
    text-align: center;
    padding: 1% 0;
    color: white;
    border-bottom: solid black 2px;
    background-color: #666666;
}

#topRecette{
    text-align: center;
    padding: 1% 0;
    color: white;
    border-bottom: solid black 2px;
    background-color: #404040;
}

#topRecette img{
    width: 650px;
    height: 450px;
    border-radius: 50px;
    border : 2px white solid;
}

#recettes{
    padding: 1% 0;
    text-align: center;
    color: white;
    border-bottom: solid black 2px;
    background-color: #333333;
}

#recettes img{
    height: 200px;
    border-radius: 50px;
}

/* FLEXBOX pour les recettes (DEBUT) */
#conteneurRecettes{
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    width: 100%;
}

<?php
/**
 * Le code suivant est sensé lire la valeur du nombre de recette à afficher dans un fichier editer par l'admin, cependant ça ne marche pas et le temps pour réaliser cette fonction est top court.
 *
 */
/*
    $sizes = [
      1 => '50%',
      2 => '35%',
      3 => '30%',
      4 => '20%'
    ];

    $handle = fopen('https://projetwebcookburn.alwaysdata.net/files/accueilNBRecette.txt', 'r');

    // valeur par défaut
    $askedSize = 2;

    // Si ça à ouvert le fichier

    if ($handle)
    {
        $firstline = fgets($handle);
        // Si on a pu récupérer la ligne.
        if ($firstline)
        {
            // On récupère le nombre de recette à afficher si on a 0 (erreur ou vrai nombre), on remet la valeur par défaut.
            if ($askedSize = intval($firstline) === 0)
                $askedSize = 2;
        }

        fclose($handle);
    }

    $size = $sizes[$askedSize];
 */
?>

.recetteContenue{
    width: 35%;
    margin-bottom: 2%;
    border : 1px white solid;
    border-radius: 75px;
    padding: 1%;
    background-color: #1a1a1a;
}

.recetteContenue p{
    margin : 10px 25%;
    padding-left: 5%;
    padding-right: 5%;
}

/* FLEXBOX pour les recettes (FIN) */

@media screen and (max-width: 1250px) {
    p{
        font-size: 20px;
    }

    #topRecette img{
        width: 100%;
        height: 100%;
        max-width: 400px;
        max-height: 250px;
    }

    /* responsive design (affichage en col au lieu de row, éviter que le texte se chevauche) */
    #conteneurRecettes {
        flex-direction: column;
        align-items: center;
    }

    .recetteContenue img {
        width: 100%;
        height: 100%;
        max-width: 400px;
        max-height: 250px;
    }

    .recetteContenue p{
        margin : 10px 10%;
    }
}