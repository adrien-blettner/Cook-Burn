<?php
require 'formatPage.inc.php';

start_page('creation', array('creationRecette.css'));
?>
    <script>
        var count = 0;

        function move ()
        {
            var id = "ingredient" + count.toString();
            count += 1;

            var ligne = document.createElement("li");

            var p1 = document.createElement("p");
            p1.setAttribute("id", id);
            p1.setAttribute("class", "ingredient");
            var text1 = document.createTextNode(document.getElementById("quantite").value);
            p1.appendChild(text1);

            var p2 = document.createElement("p");
            p2.setAttribute("id", id);
            p2.setAttribute("class", "ingredient");
            var text2 = document.createTextNode(document.getElementById("ingredient").value);
            p2.appendChild(text2);

            ligne.appendChild(p1);
            ligne.appendChild(p2);
            document.getElementById("listeIngredients").appendChild(ligne);

            document.getElementById("ingredientsNumber").value = count;
        }

        function remove()
        {

        }
    </script>
    <h1>Création de recette</h1>
    <div class="creationRecette">
        <form action="" method="post" class="creationRecetteForm" enctype="multipart/form-data"><br>
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
                <input type="text" id="quantite" name="quantite"/>
                <input type="text" id="ingredient" name="ingredient" placeholder="Ingrédient" required/></br>
                <button type="button" onclick="move();">+</button>

                <ul id="listeIngredients">

                </ul>

                <!--<label for="etapes">Étapes</label>-->
                <input type="text" name="etapes" placeholder="Etape 1" required/></br>

                <!--<label for="image">Photo de la recette</label>-->
                <input type="file" name="image" placeholder="Image" required/></br>

                <input type="submit" class="submitButton" name="action" value="Poster recette"/>
                <input type="hidden" id="ingredientsNumber" name="ingredientsNumber" value=0>
            </fieldset>
        </form>
    </div>
<?php
end_page();
?>