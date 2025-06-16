<?php
ob_start();
?>

<!-- FORMULAIRE pour ajouter un acteur -->
<form method="post" action="index.php?action=insertActor">

    <input type="text" name="nomActeur" placeholder="Nom de l’acteur" required>
    <input type="text" name="prenomActeur" placeholder="Prénom de l’acteur" required>
    <input type="date" name="dateNaissance" required>

    <select name="sexeActeur" required>
        <option value="">Sexe</option>
        <option value="M">M</option>
        <option value="F">F</option>
    </select>
    
    <button type="submit">Ajouter un acteur</button>
</form>

<!-- Affiche le nombre total d’acteurs -->
<p class="uk-label uk-label-warning">
    Il y a <?= $requete->rowCount() ?> acteur(s)
</p>

<!-- TABLEAU des acteurs -->
<table class="uk-table uk-table-striped">
    <thead>
        <tr>
            <th>NOM</th>
            <th>PRENOM</th>
            <th>ACTION</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($requete->fetchAll() as $acteur) { ?>
            <tr>
                <td><?= $acteur["nom"] ?></td>
                <td><?= $acteur["prenom"] ?></td>
                <td>
                    <a href="index.php?action=deleteActeur&id=<?= $acteur['id_acteur'] ?>">[Supprimer]</a>
                </td>
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