<?php
ob_start();
?>

<p class="uk-label uk-label-warning">
    Il y a <?= $requete->rowCount() ?> rôles
</p>

<table class="uk-table uk-table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>NOM DU RÔLE</th>
            <th>SEXE</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($requete->fetchAll() as $role) { ?>
            <tr>
                <td><?= $role["id_role"] ?></td>
                <td><?= $role["nom_role"] ?></td>
                <td><?= $role["sexe_role"] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
$titre            = "Liste des rôles";
$titre_secondaire = "Liste des rôles";
$contenu          = ob_get_clean();
require "view/template.php";
?>