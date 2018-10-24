<?php
require_once 'formatPage.inc.php';

start_page ('Profile', array ('profil.css','rolesUtilisateur.css'));
?>

        <div class="presentation">
            <div class="presentation_membre">
                <div class="titre">PROFIL</div>
                <p></p>
                <img class="image_groupe" src="/vues/images/bart.jpg" alt="Photo de "/>
                <p>Pseudo: </p>
                <p>Age: </p>
                <p>Email: </p>
                <label for="DateDeNaissance"><p>Date de naissance</p></label>
                <input min="1" max="31" class="jour" id="DateDeNaissance" placeholder="Jour" required="" type="number">
                <input min="1" max="12" class="mois" placeholder="Mois" required="" type="number">
                <input min="1900" max="2017" class="année" placeholder="Année" required="" type="number"><br><br><br
            </div>
        </div>




    </head>


    </blockquote>
<?php
end_page ();
?>