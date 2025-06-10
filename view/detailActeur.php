<?php
ob_start();

// Récupérer les infos de la personne
$personne = $requetePers->fetch();

// Récupérer les films et rôles de cet acteur
$films = $requeteFilms->fetchAll();
?>

<h1><?= $personne["prenom"] ?> <?= $personne["nom"] ?></h1>

<h2>Filmographie</h2>
<?php if (count($films) === 0) { ?>
    <p>Aucun film pour cet acteur.</p>
<?php } else { ?>
    <table class="uk-table uk-table-striped">
        <thead>
            <tr>
                <th>ID Film</th>
                <th>Titre</th>
                <th>Rôle</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($films as $f) { ?>
                <tr>
                    <td><?= $f["id_film"] ?></td>
                    <td><?= $f["titre"] ?></td>
                    <td><?= $f["nom_role"] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>

<?php
$titre            = $personne["prenom"] . ' ' . $personne["nom"];
$titre_secondaire = "Détail de l’acteur : " . $titre;
$contenu          = ob_get_clean();
require "view/template.php";
?>