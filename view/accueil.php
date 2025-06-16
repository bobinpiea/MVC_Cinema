<?php ob_start(); ?>


<main>


<h1>Bienvenue sur le site du cinéma</h1>
<p>Utilisez le menu pour naviguer entre les films, les acteurs, les réalisateurs, etc.</p>
















</main>

<?php
$titre = "Accueil";
$titre_secondaire = "Bienvenue !";
$contenu = ob_get_clean();
require "view/template.php";
?>