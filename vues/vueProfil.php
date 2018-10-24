<?php
require_once 'formatPage.inc.php';

start_page ('Profil', array ('profil.css','rolesUtilisateur.css'));
?>
        <div class="presentation">
            <div class="presentation_membre">
                <div class="titre">PROFIL</div>
                <p></p>
                <p>Pseudo: </p>
                <p>Age: </p>
                <p>Email: </p>
                <label for="DateDeNaissance"><p>Date de naissance</p></label>
                <input min="1" max="31" class="jour" id="DateDeNaissance" placeholder="Jour" required="" type="number">
                <input min="1" max="12" class="mois" placeholder="Mois" required="" type="number">
                <input min="1900" max="2017" class="année" placeholder="Année" required="" type="number">
            </div>
        </div>
<?php
end_page ();
?>