<?php ob_start(); ?>


<form method="post" action="index.php?action=insertFilm" enctype="multipart/form-data">

    <input type="text"   name="titreFilm"   placeholder="Titre du film"        required>
    <input type="text"   name="anneeSortie" placeholder="Année de sortie (ex: 2022)" required>
    <input type="number" name="duree"       placeholder="Durée (minutes)"      required>
    <input type="number" step="0.1" name="note"       placeholder="Note (0–5)"           required>
    <input type="file"    name="affiche"    placeholder="Charger votre image (facultatif)">
    <textarea name="synopsis" placeholder="Synopsis" ></textarea>

    <br><br>

    <!-- Liste  des réalisateurs -->
    <label>Choisir un réalisateur :</label><br>
    <select name="id_realisateur" required>
        <option value="">-- Sélectionner un réalisateur --</option>
        <?php foreach ($realisateurs->fetchAll() as $realisateur) { ?>
            <option value="<?= $realisateur['id_realisateur'] ?>">
                <?= $realisateur['prenom'] ?> <?= $realisateur['nom'] ?>
            </option>
        <?php } ?>
    </select>

    <br><br>

    <!-- Liste des genres à cocher -->
    <label>Genres :</label>
    <?php foreach ($genres->fetchAll() as $genre) { ?>
        <input type="checkbox" name="genres[]" value="<?= $genre["id_genre"] ?>">
        <?= $genre["nom_genre"] ?>
    <?php } ?>

    <br>
    <button type="submit">Ajouter un film</button>
</form>

    <!-- Affiche le nombre total d’acteurs, ex "y a 10 films -->
<p class="uk-label uk-label-warning">
    Il y a <?= $requete->rowCount() ?> film(s)
</p>

<table class="uk-table uk-table-striped">
    <thead>
        <tr>
            <th>TITRE</th>
            <th>ANNEE_SORTIE</th>
            <th>ACTION</th> <!-- Colonne pour supprimer -->
        </tr>
    </thead>
    <tbody>
        <?php foreach ($requete->fetchAll() as $film) { ?>
            <tr>
                <td><?= $film["titre"] ?></td>
                <td><?= $film["annee_sortie"] ?></td>
                <td> <a href="index.php?action=deleteFilm&id=<?= $film['id_film'] ?>">[Supprimer]</a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
$titre = "Liste des films";
$titre_secondaire = "Liste des films";
$contenu = ob_get_clean();

require "view/template.php";

// "fetchAll() est une méthode PHP de l’objet PDOStatement".  (Faut que je cherche)
// Elle récupère toutes les lignes du résultat de la requête SQL 
// et les place dans un tableau (chaque ligne devient un sous-tableau).


