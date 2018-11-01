<?php
require 'formatPage.inc.php';

start_page('administration | supprimer un membre');
?>

    <form onsubmit="return confirm('êtes vous sûr de vouloir supprmier ce compte ?')" action="/admin/supprimer-compte" method="post">
        <textarea name="raison" placeholder="raison de la suppresion du compte."></textarea>
        <? echo '<input name="id" value="'.$_POST['id'].'" hidden>';?>
        <button name="action" value="confirmer_supression">Supprimer l'utilisateur</button>
    </form>

    <form action="/admin">
        <button>annuler</button>
    </form>

<?php
end_page();
?>