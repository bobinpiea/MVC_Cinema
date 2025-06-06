<?php ob_start(); ?>


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