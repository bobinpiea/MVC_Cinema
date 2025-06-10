<?php
ob_start();
?>


<form method="post" action="index.php?action=insertGenre">
    <input 
        type="hidden" 
        name="action" 
        value="insertGenre"
    >
    <input 
        type="text" 
        name="nomGenre" 
        placeholder="Nouveau genre" 
        required
    >
    <button type="submit">Ajouter un genre</button>
</form>

<p class="uk-label uk-label-warning">
    Il y a <?= $requete->rowCount() ?> genres
</p>

<ul>
    <?php foreach ($requete->fetchAll() as $genre) { ?>
        <li>
            <?= $genre["nom_genre"] ?>
        </li>
    <?php } ?>
</ul>

<?php
$titre            = "Liste des genres";
$titre_secondaire = "Liste des genres";
$contenu          = ob_get_clean();
require "view/template.php";
?>