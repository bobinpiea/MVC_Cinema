<?php
// (On démarre le “tampon”, càd qu’au lieu d’envoyer directement le code HTML au navigateur,
//  PHP le met de côté dans une mémoire temporaire --> tampon.)
ob_start();

?>

<!-- Affiche le nombre total d’acteurs, ex “y a 10 acteurs” -->
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
                <td><?= $acteur["prenom"]?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
$titre = "Liste des acteurs"; // (Titre qui apparaîtra dans l’onglet du navigateur)
$titre_secondaire = "Liste des acteurs";
$contenu = ob_get_clean(); // (On vide le tampon et on stocke tout le HTML capturé dans $contenu)

require "view/template.php";
// (On inclut le template général qui affichera $titre, $titre_secondaire et $contenu)

//fetchAll() 