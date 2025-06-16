<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $titre ?></title> <!-- C'est la variable qui fut déclaré dans chaque vue 
        pour afficher  le titre de la page dans le navigateur -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        
        <!-- Le css template sera commun à toutes les pages  -->
            <link rel="stylesheet" href="public/css/template.css">
        <!-- Appel le CSS de la page d'accueil quand c'est le cass  -->
         
        
    </head>

    <body>
        <header>
            <nav>
                <div class="nav-gauche">
                    <a href="index.php?action=accueil">
                         <img class="logo" src="public/img/clapOeil.webp" alt="Logo du site">
                    </a>

                     <a href="index.php?action=accueil">
                        <p class="nom-site">CLAP’OEIL</p>
                    </a> 

                    <div class="liens-principaux">
                        <a href="index.php?action=accueil">Accueil</a>
                        <a href="index.php?action=listFilms">Films</a>
                        <a href="index.php?action=listActeurs">Acteurs</a>
                        <a href="index.php?action=listRealisateurs">Réalisateurs</a>
                    </div>
                </div>

                <div class="nav-droite">
                    <a href="">Espace membre</a>
                    <a href="">Connexion</a>
                    <a href="">Créer un compte</a>
                </div>
            </nav>
        </header>

        <main>
            <h1>PDO Cinema</h1>
            <h2><?= $titre_secondaire ?></h2>
                    <!-- Ici, on affiche tout le contenu qu’on a préparé dans le fichier vue.
                        On l’a d’abord gardé en mémoire avec ob_start(), puis récupéré avec ob_get_clean().
                        On a mis ce contenu dans la variable $contenu, et ici on l’affiche dans le template.
                        Comme ça, on a une seule structure (le squelette), 
                        et juste le contenu change selon la page.
                    -->
            <?= $contenu ?>
        </main>

        <footer class="footer">

            <div> 
                <a href="">A propos</a>
                <a href="">Contact</a>
                <a href="">Podcast</a>
                <a href="">Interview</a>
            </div>

            <p>&copy; Clap’Oeil. Créé par des passionnés de cinéma en France.</p>

            <div> <!-- pour afficher les icones des réseaux sociaux (A mettre en Blanc plus tard) -->
                <a href="https://www.facebook.com/" target="_blank"><i class="fa-brands fa-facebook"></i></a>
                <a href="https://www.twitter.com/" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="https://www.tiktok.com/" target="_blank"><i class="fa-brands fa-tiktok"></i></a>
                <a href="https://www.youtube.com/" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                <a href="https://www.instagram.com/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
            </div>

        </footer>
    </body>
</html>