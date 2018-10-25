<?php
require 'formatPage.inc.php';

start_page('creation', array('creationRecette.css'));
?>
    <script>
        var count = 0;

        function moveIngredient ()
        {
            var name = "ingredient" + count.toString();
            var nameList = name + "List";
            name += "[]";
            count += 1;

            var ligne = document.createElement("li");
            ligne.setAttribute("class", "LIIngredient");
            ligne.setAttribute("id", nameList);

            var input1 = document.createElement("input");
            input1.setAttribute("name", name);
            input1.setAttribute("class", "ingredient");
            input1.setAttribute("value",document.getElementById("quantite").value);
            input1.readOnly = true;

            var input2 = document.createElement("input");
            input2.setAttribute("name", name);
            input2.setAttribute("class", "ingredient");
            input2.setAttribute("value",document.getElementById("ingredient").value);
            input2.readOnly = true;

            var remove = document.createElement("button");
            remove.appendChild(document.createTextNode("x"));
            remove.setAttribute("type", "button");
            remove.setAttribute("onclick", "remove(\"" + nameList + "\");");
            remove.setAttribute("name", name);

            ligne.appendChild(input1);
            ligne.appendChild(input2);
            ligne.appendChild(remove);
            document.getElementById("listeIngredients").appendChild(ligne);
        }

        function moveEtape() {

        }

        function remove($name)
        {
            var li = document.getElementById($name);
            li.parentNode.removeChild(li);
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
                <input type="text" id="quantite"/>
                <input type="text" id="ingredient" placeholder="Ingrédient"/></br>
                <button type="button" onclick="moveIngredient();">+</button>

                <ul id="listeIngredients"></ul>

                <!--<label for="etapes">Étapes</label>-->
                <input type="text" name="etapes" placeholder="Etape 1" required/></br>
                <button type="button" onclick="moveEtape();">+</button>

                <ul id="listeEtapes"></ul>

                <!--<label for="image">Photo de la recette</label>-->
                <input type="file" name="image" placeholder="Image" required/></br>

                <input type="submit" class="submitButton" name="action" value="Poster recette" />
            </fieldset>
        </form>
    </div>
<?php
end_page();
?>