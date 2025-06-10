<?php
ob_start();

// Récupérer le nom du genre
$genre = $requeteGenre->fetch();

// Récupérer les films associés à ce genre
$films = $requeteFilms->fetchAll();
?>

<h1><?= $genre["nom_genre"] ?></h1>

<h2>Films dans ce genre</h2>
<?php if (count($films) === 0) { ?>
    <p>Aucun film pour ce genre.</p>
<?php } else { ?>
    <table class="uk-table uk-table-striped">
        <thead>
            <tr>
                <th>ID Film</th>
                <th>Titre</th>
                <th>Année</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($films as $f) { ?>
                <tr>
                    <td><?= $f["id_film"] ?></td>
                    <td><?= $f["titre"] ?></td>
                    <td><?= $f["annee_sortie"] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>

<?php
$titre            = $genre["nom_genre"];
$titre_secondaire = "Détail du genre : " . $genre["nom_genre"];
$contenu          = ob_get_clean();
require "view/template.php";
?>