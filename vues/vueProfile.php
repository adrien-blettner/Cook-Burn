<?php
require_once 'formatPage.inc.php';

start_page ('Profile', array ('profil.css','rolesUtilisateur.css'));
?>
    <div class="presentation">
        <table>
            <tr>
                <td>
                    <div class="presentation_groupe">
                    <div class="presentation_membre">
                    <p></p>
                    <img class="image_groupe" src="images/bart.jpg" alt="Photo de "/>
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


    </blockquote>
<?php
end_page ();
?>