<?php
ob_start();
?>

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