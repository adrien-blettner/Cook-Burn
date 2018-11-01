<?php
require 'formatPage.inc.php';

start_page('administration', array('admin.css'));
?>
    <script>
        function hide2()
        {
            let ele = document.getElementById("recettes");
            let ele2 = document.getElementById("membres");
            ele.style.display = "none";
            ele2.style.display = "block";
        }

        function hide1()
        {
            let ele = document.getElementById("membres");
            let ele2 = document.getElementById("recettes");
            ele.style.display = "none";
            ele2.style.display = "block";
        }

        function deleteUser (id)
        {
            let container = document.getElementById("container");
            let form = document.createElement("form");
            form.setAttribute("action", "/admin/supprimer-compte");
            form.setAttribute("method", "post");
            form.setAttribute("style", "display: none;");
            form.setAttribute("id", "form_supprimer_utilisateur");

            let input1 = document.createElement("input");
            input1.setAttribute("name", "id");
            input1.setAttribute("value", id);

            let input2 = document.createElement("input");
            input2.setAttribute("name", "action");
            input2.setAttribute("value", "supprimer-utilisateur");

            form.appendChild(input1);
            form.appendChild(input2);

            container.appendChild(form);

            form = document.getElementById("form_supprimer_utilisateur");
            form.submit();
        }

        function deleteRecette(id)
        {
            if (!confirm("Etes vous certain de supprimer cette recette ?"))
                return;

            let container = document.getElementById("container");
            let form = document.createElement("form");
            form.setAttribute("action", "/admin/supprimer-recette");
            form.setAttribute("method", "post");
            form.setAttribute("style", "display: none;");
            form.setAttribute("id", "form_supprimer_recette");

            let input1 = document.createElement("input");
            input1.setAttribute("name", "id");
            input1.setAttribute("value", id);

            let input2 = document.createElement("input");
            input2.setAttribute("name", "action");
            input2.setAttribute("value", "supprimer-recette");

            form.appendChild(input1);
            form.appendChild(input2);

            container.appendChild(form);

            form = document.getElementById("form_supprimer_utilisateur");
            form.submit();
        }
    </script>

    <div id="container">
        <button onclick="hide1();">Liste des recettes</button>
        <button onclick="hide2();">Liste des membres</button>

        <div id="membres" style="display: none;">
            <ul>
                <?php
                    foreach ($listeUtilisateurs as $utilisateur)
                    {
                        echo '<li class="noStyle">';
                        echo '<p class="alligner">'. $utilisateur->getPseudo() .'</p>';
                        echo '<p class="alligner">'. $utilisateur->getEmail().'</p>';
                        echo '<button class="alligner" onclick="deleteUser('.$utilisateur->getId().')">x</button>';
                        echo '<form class="alligner" action="/profil" method="post"><button name="action" value="askUpdate" class="alligner">editer</button><input name="id" value="'.$utilisateur->getId().'" hidden></form>';
                        echo '</li>' . PHP_EOL;
                    }
                ?>
            </ul>
        </div>

        <div id="recettes">
            <ul>
                <?php
                foreach ($listeRecettes as $recette)
                {
                    echo '<li class="noStyle">';
                    echo '<p class="alligner">id : '. $recette->getId() .'</p>';
                    echo '<p class="alligner">'. $recette->getNom().'</p>';
                    echo '<button class="alligner" onclick="deleteRecette('.$recette->getId().')">supprimer</button>';
                    echo '<form class="alligner" method="post" action="/editeur-de-recette/editer"><button class="alligner" name="idEditer" value="'.$recette->getId().'">éditer la recette</button></form>';
                    echo '<form class="alligner" action="/recette/'.$recette->getId().'"><button class="alligner">voir la recette</button></form>';
                    echo '</li>' . PHP_EOL;
                }
                ?>
            </ul>
        </div>
    </div>
<?php
end_page();
?>