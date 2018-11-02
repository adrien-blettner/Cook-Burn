<?php
require 'formatPage.inc.php';

start_page('creation', array('creationRecette.css'));
?>
    <script>
        let nbIngredients = <?php if (null !== $ingredients = $recette->getIngredients()) echo (substr_count($ingredients, '|') + 1); else echo 0;?>;
        let nbEtapes = <?php if (null !== $etapes = $recette->getEtapes()) echo (substr_count($etapes, '|') + 1); else echo 0;?>;

        function moveIngredient ()
        {
            let name = "ingredients";
            let nameList = "list_" + name + nbIngredients.toString();
            name += "[" + nbIngredients.toString() +"][]";
            nbIngredients += 1;

            let ligne = document.createElement("li");
            ligne.setAttribute("class", "list_ingredient");
            ligne.setAttribute("id", nameList);

            let quantite = document.createElement("input");
            quantite.setAttribute("name", name);
            quantite.setAttribute("class", "ingredient");
            quantite.setAttribute("value",document.getElementById("quantite").value);
            quantite.readOnly = true;

            document.getElementById("quantite").value = "";

            let ingredient = document.createElement("input");
            ingredient.setAttribute("name", name);
            ingredient.setAttribute("class", "ingredient");
            ingredient.setAttribute("value",document.getElementById("ingredient").value);
            ingredient.readOnly = true;

            document.getElementById("ingredient").value = "";

            let remove = document.createElement("button");
            remove.appendChild(document.createTextNode("x"));
            remove.setAttribute("type", "button");
            remove.setAttribute("onclick", "remove(\"" + nameList + "\");");

            ligne.appendChild(quantite);
            ligne.appendChild(ingredient);
            ligne.appendChild(remove);
            document.getElementById("listeIngredients").appendChild(ligne);
        }

        function moveEtape() {
            let name = "etapes";
            let listName = "list_" + name + nbEtapes.toString();
            name += "[]";
            nbEtapes += 1;

            let ligne = document.createElement("li");
            ligne.setAttribute("class", "list_etape");
            ligne.setAttribute("id", listName);

            let etape = document.createElement("input");
            etape.setAttribute("name", name);
            etape.setAttribute("class", "etape");
            etape.setAttribute("value",document.getElementById("etape").value);
            etape.readOnly = true;

            document.getElementById("etape").value = "";

            let remove = document.createElement("button");
            remove.appendChild(document.createTextNode("x"));
            remove.setAttribute("type", "button");
            remove.setAttribute("onclick", "remove(\"" + listName + "\");");

            ligne.appendChild(etape);
            ligne.appendChild(remove);
            document.getElementById("listeEtapes").appendChild(ligne);
        }

        function remove($name)
        {
            let li = document.getElementById($name);
            li.parentNode.removeChild(li);
        }
    </script>
    <h1>Création de recette</h1>
    <div class="creationRecette">
        <form action="" method="post" class="creationRecetteForm" enctype="multipart/form-data"><br>
            <fieldset>
                <?php
                if ($messageErreur !== null)
                    Tools::betterDump($messageErreur);
                ?>
                <input type="text" name="nom" placeholder="Nom recette" required <?php if (null !== $nom = $recette->getNom() ) echo 'value="'.$nom.'"'; ?>/></br>

                <input type="number" name="nbConvives" placeholder="Nombre de convives" required <?php if (null !== $nbConvive = $recette->getNbConvives()) echo 'value="'.$nbConvive.'"'; ?>/></br>

                <input type="text" name="descCourte" placeholder="Une courte description" required <?php if (null !== $descCourte = $recette->getDescriptionCourte()) echo 'value="'.$descCourte.'"'; ?>/></br>

                <textarea name="descLongue" rows="5" cols="50" placeholder = "Une description bien plus détaillée" required ><?php if (null !== $descLongue = $recette->getDescriptionLongue()) echo $descLongue; ?></textarea></br>


                <input type="text" id="quantite" placeholder="quantité"/>
                <input type="text" id="ingredient" placeholder="Ingrédient"/></br>
                <button type="button" onclick="moveIngredient();">+</button>

                <ul id="listeIngredients">
                    <?php
                    // S'il y a des ingrédients on les affiches
                    if (null !== $ingredients = $recette->getIngredients())
                    {
                        $i = 0;

                        foreach (explode('|', $ingredients) as $ingredient)
                        {
                            $pouet = explode('Δ', $ingredient);
                            echo '<li class="list_ingredient" id="list_ingredients' . $i . '">' . PHP_EOL;
                            echo '<input name="ingredients[' . $i . '][]" class="ingredient" value="' . $pouet[0] . '" readonly>' . PHP_EOL;
                            echo '<input name="ingredients[' . $i . '][]" class="ingredient" value="' . $pouet[1] . '" readonly>' . PHP_EOL;
                            $r = 'remove(&quot;list_ingredients' . $i . '&quot;);';
                            echo '<button type="button" onclick="' . $r . '">x</button>' . PHP_EOL;
                            echo '</li>' . PHP_EOL;
                            ++$i;
                        }
                    }
                    ?>
                </ul>

                <input type="text" id="etape" placeholder="Ajoutez une étape"/></br>
                <button type="button" onclick="moveEtape();">+</button>

                <ul id="listeEtapes">
                    <?php
                    // S'il y a des ingrédients on les affiches
                    if (null !== $etapes = $recette->getEtapes())
                    {
                        $i = 0;
                        foreach (explode('|', $etapes) as $etape)
                        {
                            echo '<li class="list_etape" id="list_etapes'.$i.'">';
                            echo '<input name="etapes[]" class="etape" value="'.$etape.'" readonly>';
                            $r = 'remove("list_etapes'.$i.'");';
                            echo '<button type="button" onclick="'.$r.'">x</button>';
                            echo '</li>';

                            ++$i;
                        }
                    }
                    ?>
                </ul>

                <!-- TODO le remettre à la fin du dev required-->
                <input type="file" name="photo" placeholder="Image" <?php if (isset($haveImage) and $haveImage === false) echo 'required'?>/></br>

                <input type="submit" class="submitButton" name="action" value="Poster recette" />
            </fieldset>
        </form>
    </div>
<?php
end_page();
?>