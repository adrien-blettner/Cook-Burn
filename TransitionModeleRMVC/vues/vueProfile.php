<?php
require_once 'formatPage.inc.php';

start_page ('Profile', array ('profil.css','rolesUtilisateur.css'));
?>
    <div class="presentation">
        <table>
            <tr>
                <td>
                    <div class="presentation_groupe"
                    <div class="presentation_membre"
                    <p></p>
                    <img class="image_groupe" src="images/bart.jpg" alt="Photo de ">
    </div>
    </div>
    </td>
    <td>
        <div class="presentation_groupe"
        <div class="presentation_membre"
        <p></p>
        <p>Pseudo: </p>
        <p>Age: </p>
        <p>Email: </p>

        <label for="DateDeNaissance"><p>Date de naissance</p></label>
        <input min="1" max="31" class="jour" id="DateDeNaissance" placeholder="Jour" required="" type="number">
        <input min="1" max="12" class="mois" placeholder="Mois" required="" type="number">
        <input min="1900" max="2017" class="année" placeholder="Année" required="" type="number"><br><br><br>


        <textarea onkeyup="reste(this.value);" name="impression" rows="2" cols="50" placeholder="Ecrivez en plus sur vous ici..."></textarea>
        <span id="caracteres">450</span>caractères restants
        <script type="text/javascript">
            function reste(texte)
            {
                var restants=450-texte.length;
                document.getElementById('caracteres').innerHTML=restants;
            }
        </script>


        </div>
        </div>
    </td>

    </tr>
    </table>
    </div>
    <div class="bord">
        <a href="form.php" class="bouton13">Réinitialisez votre mot de passe</a>
        <a href="form.php" class="bouton13">Déconnexion</a>
    </div>

    </head>

    <h1> Rôles et permissions </h1>


    <blockquote>
        <div class="Titre"> Voici les différents rôles: </div><br>
        - (Super) Administrateur (tous les droits)

        <br>

        - Membre


        <br>- Visiteur
        <div class="Titre"> Description des différents permissions:</h2></div>

        <div class="Role">Administrateur: <br></div>
        <div class="Text">  L'administrateur aura tous les droits. <br></div>

        <div class="Role"> Membre : <br></div>
        <div class="Text">   Le membre pourra disposer de son propre compte, et aura ainsi la possibilité d'ajouter ses propres recettes, de noter grâce au système de burn et commenter celles des autres utilisateurs.<br></div>

        <div class="Role"> Visiteur : <br></div>
        <div class="Text"> Le visiteur aura simplement la possibilité de " visiter" la page sans rien ne pouvoir y changer. Il consultera seulement les pages publiques.<br></div>

        <div class = "TitreMembre"> Devenez membre en vous connectant ici!  <br></div>
        <div class="bord"> <a href="http://projetwebcookburn.alwaysdata.net/connexion.php" class="bouton13"> Devenir membre </a></div>


    </blockquote>
<?php
end_page ();
?>