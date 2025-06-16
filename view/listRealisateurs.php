<?php ob_start(); ?>

<form method="post" action="index.php?action=insertRealisateur">
    <input type="text" name="nomRealisateur" placeholder="Nom du réalisateur" required>
    <input type="text" name="prenomRealisateur" placeholder="Prénom du réalisateur" required>
    <input type="date" name="dateNaissanceRealisateur" required>
    <select name="sexeRealisateur" required>
        <option value="">Sexe</option>
        <option value="M">M</option>
        <option value="F">F</option>
    </select>
    <button type="submit">Ajouter un réalisateur</button>
</form>

<p class="uk-label uk-label-warning">
    Il y a <?= $realisateurs->rowCount() ?> réalisateur(s)
</p>

<table class="uk-table uk-table-striped">
    <thead>
        <tr>
            <th>NOM</th>
            <th>PRÉNOM</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($realisateurs->fetchAll() as $realisateur) { ?>
            <tr>
                <td><?= $realisateur["nom"] ?></td>
                <td><?= $realisateur["prenom"] ?></td>
                <td>
                    <a href="index.php?action=deleteRealisateur&id=<?= $realisateur['id_realisateur'] ?>">[Supprimer]</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
$titre = "Liste des réalisateurs";
$titre_secondaire = "Liste des réalisateurs";
$contenu = ob_get_clean();
require "view/template.php";