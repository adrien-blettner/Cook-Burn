<?php
require 'formatPage.inc.php';

start_page('creation', array('creationRecette.css'));
?>

    <h1>Création de recette</h1>
    <div class="creationRecette">
        <form action="/modeles/process_formulaire.php" method="post" class="creationRecetteForm"><br>
            <fieldset>
                <!--<label for="nomRecette">Nom</label>-->
                <input type="text" name="nomRecette" placeholder="Nom recette"/></br>

                <!--<label for="nbConvives">Nombre de convives</label>-->
                <input type="text" name="nbConvives" placeholder="Nombre de convives"/></br>

                <!--<label for="descriptionCourte">Description courte</label>-->
                <input type="text" name="descriptionCourte" placeholder="Une courte description"/></br>

                <!--<label for="descriptionLongue">Description longue</label>-->
                <textarea name="descriptionLongue" rows="5" cols="50" placeholder = "Une description bien plus détaillée"></textarea></br>

                <!--<label for="ingredient">Ingrédients</label>-->
                <input type="text" name="ingredient" placeholder="Ingrédient"/></br>

                <!--<label for="etapes">Étapes</label>-->
                <input type="text" name="etapes" placeholder="Etape 1"/></br>

                <!--<label for="image">Photo de la recette</label>-->
                <input type="file" name="image" placeholder="Image"/></br>

                <input type="submit" class="submitButton" name="action" value="Poster recette"/>

            </fieldset>
        </form>
    </div>

<?php
end_page();
?>
