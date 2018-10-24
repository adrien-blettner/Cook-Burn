<?php
require 'formatPage.inc.php';

start_page('creation', array('creationRecette.css'));
?>
    <h1>Création de recette</h1>
    <div class="creationRecette">
        <form action="/recette/1" method="post" class="creationRecetteForm" enctype="multipart/form-data"><br>
            <fieldset>
                <!--<label for="nomRecette">Nom</label>-->
                <input type="text" name="nomRecette" placeholder="Nom recette" required/></br>

                <!--<label for="nbConvives">Nombre de convives</label>-->
                <input type="text" name="nbConvives" placeholder="Nombre de convives" required/></br>

                <!--<label for="descriptionCourte">Description courte</label>-->
                <input type="text" name="descriptionCourte" placeholder="Une courte description" required/></br>

                <!--<label for="descriptionLongue">Description longue</label>-->
                <textarea name="descriptionLongue" rows="5" cols="50" placeholder = "Une description bien plus détaillée" required></textarea></br>

                <!--<label for="ingredient">Ingrédients</label>-->
                <input type="text" name="ingredient" placeholder="Ingrédient" required/></br>

                <!--<label for="etapes">Étapes</label>-->
                <input type="text" name="etapes" placeholder="Etape 1" required/></br>

                <!--<label for="image">Photo de la recette</label>-->
                <input type="file" name="image" placeholder="Image" required/></br>

                <input type="submit" class="submitButton" name="action" value="Poster recette"/>
            </fieldset>
        </form>
    </div>
<?php
end_page();
?>