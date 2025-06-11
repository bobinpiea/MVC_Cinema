<?php ob_start(); ?>



<!-- Formulaire pour ajouter un film -->
<form method="post" action="index.php?action=insertFilm" style="margin-bottom:1em;">
    <input type="text"   name="titreFilm"   placeholder="Titre du film"        required>
    <input type="date"   name="anneeSortie" placeholder="Année de sortie"       required>
    <input type="number" name="duree"       placeholder="Durée (minutes)"      required>
    <input type="number" step="0.1" name="note"       placeholder="Note (0–5)"           required>
    <input type="url"    name="affiche"    placeholder="URL de l’affiche (optionnel)">
     <textarea name="synopsis" placeholder="Synopsis" ></textarea>
    <button type="submit">Ajouter un film</button>
</form>

    <!-- Affiche le nombre total d’acteurs, ex "y a 10 films -->
<p class="uk-label uk-label-warning">
    Il y a <?= $requete->rowCount() ?> films
</p>

<table class="uk-table uk-table-striped">
    <thead>
        <tr>
            <th>TITRE</th>
            <th>ANNEE_SORTIE</th>
        </tr>
    </thead>
    <tbody>
       
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