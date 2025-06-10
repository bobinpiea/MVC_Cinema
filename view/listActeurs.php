<?php
ob_start();
?>

<form method="post" action="index.php?action=insertActor">

    <input type="text" name="nom" placeholder="Nom" required>
    <input type="text" name="prenom" placeholder="Prénom" required>
    <input type="date" name="date_naissance" placeholder="Date de naissance" required>

    <select name="sexe" required>
        <option value="">Sexe</option>
        <option value="M">M</option>
        <option value="F">F</option>
    </select>
    
    <button type="submit">Ajouter un acteur</button>
</form>



<p class="uk-label uk-label-warning">
    Il y a <?= $requete->rowCount() ?> acteurs
</p>

<table class="uk-table uk-table-striped">
    <thead>
        <tr>
            <th>NOM</th>
            <th>PRENOM</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($requete->fetchAll() as $acteur) { ?>
            <tr>
                <td><?= $acteur["nom"] ?></td>
                <td><?= $acteur["prenom"] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
$titre            = "Liste des acteurs";
$titre_secondaire = "Liste des acteurs";
$contenu          = ob_get_clean();
require "view/template.php";
?>