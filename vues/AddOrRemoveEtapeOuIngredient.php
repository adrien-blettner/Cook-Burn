<?php

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