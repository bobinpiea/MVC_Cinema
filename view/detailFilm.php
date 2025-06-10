<?php
ob_start();

// Récupérer les infos du film
$film = $requeteFilm->fetch();

// Récupérer les genres
$genres = $requeteGenres->fetchAll();

// Récupérer le casting
$casting = $requeteCasting->fetchAll();
?>

<h1><?= $film["titre"] ?></h1>

<p>Année de sortie : <?= $film["annee_sortie"] ?></p>
<p>Durée : <?= $film["duree"] ?> minutes</p>
<p>Note : <?= $film["note"] ?>/5</p>

<h2>Synopsis</h2>
<p><?= $film["synopsis"] ?></p>

<h2>Genres</h2>
<?php if (count($genres) === 0) { ?>
    <p>Aucun genre pour ce film.</p>
<?php } else { ?>
    <ul>
        <?php foreach ($genres as $genre) { ?>
            <li><?= $genre["nom_genre"] ?></li>
        <?php } ?>
    </ul>
<?php } ?>

<h2>Casting</h2>
<?php if (count($casting) === 0) { ?>
    <p>Aucun acteur pour ce film.</p>
<?php } else { ?>
    <table class="uk-table uk-table-striped">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Rôle</th>
                <th>Sexe</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($casting as $c) { ?>
                <tr>
                    <td><?= $c["nom_acteur"] ?></td>
                    <td><?= $c["prenom_acteur"] ?></td>
                    <td><?= $c["nom_role"] ?></td>
                    <td><?= $c["sexe_role"] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>

<?php
$titre            = $film["titre"];
$titre_secondaire = "Détail du film : " . $film["titre"];
$contenu          = ob_get_clean();
require "view/template.php";
?>