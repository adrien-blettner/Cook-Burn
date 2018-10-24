<?php
    $cpt = $_GET['cpt'];
    echo '<div id="' . $cpt . '" class="selectingr">
        <select id="ingr' .$cpt . '" name="ingr' . $cpt . '">
            <option value="0">Ingrédient ' . $cpt . '</option>';
            $BDingredient = new BD_Ingredients();
            foreach ($BDingredient->findAll($dbLink) as $ing) {
            echo '<option value="' . $ing->getId() . '">' . $ing->getNomIngredients() . '</option>';
            }
            echo '</select>
        <select class="unit" name="unit' . $cpt . '">
            <option value="0">Unité</option>
            <option value="1">Masse(en gramme)</option>
            <option value="2">Volume(en cl)</option>
        </select>
        <input type="text" placeholder="Quantité" name="quantite' . $cpt . '"/>
        <button type="button" id="' . $cpt . '" class="btn_remove_ingr">REM</button></div>';
?>


<div id="dynamic_ingr">

        <div id="1" class="selectingr">
    <select id="ingr1" name="ingr1">
        <option value="0">Ingrédient 1</option>
        <?php
        $BDingredient = new BD_Ingredients();
        foreach ($BDingredient->findAll($dbLink) as $ing)
        {
            echo'<option value="' . $ing->getId() . '">' . $ing->getNomIngredients()  . '</option>';
        }
        ?>
    </select>
            <select class="unit" name="unit1">
                <option value="0">Unité</option>
                <option value="1">Masse(en gramme)</option>
                <option value="2">Volume(en cl)</option>
            </select>
            <input type="text" placeholder="Quantité" name="quantite1"/>
    <button type="button" id="1" class="btn_remove_ingr">REM</button>
        </div>

        <div id="2" class="selectingr">
    <select id="ingr2" name="ingr2">
        <option value="0">Ingrédient 2</option>
        <?php
        $BDingredient = new BD_Ingredients();
        foreach ($BDingredient->findAll($dbLink) as $ing)
        {
            echo'<option value="' . $ing->getId() . '">' . $ing->getNomIngredients()  . '</option>';
        }
        ?>
    </select>
            <select class="unit" name="unit2">
                <option value="0">Unité</option>
                <option value="1">Masse(en gramme)</option>
                <option value="2">Volume(en cl)</option>
            </select>
            <input type="text" placeholder="Quantité" name="quantite2"/>
    <button type="button" id="2" class="btn_remove_ingr">REM</button>
        </div>


        <div id="3" class="selectingr">
    <select id="ingr3" name="ingr3">
        <option value="0">Ingrédient 3</option>
        <?php
        $BDingredient = new BD_Ingredients();
        foreach ($BDingredient->findAll($dbLink) as $ing)
        {
            echo'<option value="' . $ing->getId() . '">' . $ing->getNomIngredients()  . '</option>';
        }
        ?>
    </select>
            <select class="unit" name="unit3">
                <option value="0">Unité</option>
                <option value="1">Masse(en gramme)</option>
                <option value="2">Volume(en cl)</option>
            </select>
            <input type="text" placeholder="Quantité" name="quantite3"/>
    <button type="button" id="3" class="btn_remove_ingr">REM</button>
        </div>
    </div>
    <button type="button" id="add_view">ADD</button>

    <div id="dynamic_etape">
        <div id="1" class="etape">
           <input type="text" id="text_etape1" placeholder="Etape 1" name="etape1"/>
            <button type="button" id="1" class="btn_remove_etape">REM</button>
        </div>

        <div id="2" class="etape">
           <input type="text" id="text_etape2" placeholder="Etape 2" name="etape2"/>
            <button type="button" id="2" class="btn_remove_etape">REM</button>
        </div>

        <div id="3" class="etape">
           <input type="text" id="text_etape3" placeholder="Etape 3" name="etape3"/>
            <button type="button" id="3" class="btn_remove_etape">REM</button>
        </div>

    </div>
    <button type="button" id="add_etape">ADD</button>

    <select name="statut">
        <option value="0">Public</option>
        <option value="1">Privé</option>
        <option value="2">Brouillon</option>
    </select>

    <input type="submit" name="action" value="Créer la recette"/>
 </form>
 <?php
 end_page();
 ?>
<script>
    $(document).ready(function () {
        $('#add_view').click(function () {
            var cpt = parseInt($('#dynamic_ingr.selecingr:last-of-type').attr("id")) + 1;
            if (!Number.isInteger(cpt)) {
                cpt = 1;
            }
            $.post('addViewIngredient.php?cpt=' + cpt, function (data) {
                $('#dynamic_ingr').append(data);
            });
        });
        $(document).on('click', '.btn_remove_ingr', function () {
            var button_id = $(this).attr("id");
            $("#dynamic_ingr #" + button_id).remove();
        });

        
    });
    $(document).ready(function () {
        $('#add_etape').click(function () {
            var cpt = parseInt($('#dynamic_etape.etape:last-of-type').attr("id")) + 1;
            if (!Number.isInteger(cpt)){
                cpt = 1;
            }
            $.post('addViewEtape.php?cpt=' + cpt, function (data) {
                $('#dynamic_etape').append(data);

            });
        });
        $(document).on('click','.btn_remove', function () {
            var button_id = $(this).attr("id");
            $('#dynamic_etape#' + button_id).remove();

        });
    });
</script>