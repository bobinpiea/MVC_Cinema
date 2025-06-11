

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titre ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../public/css/template.css">
</head>
<body>
    <head>

        <div>
            <a href="">
                <img src="/public/img/clapOeil.webp" alt="Logo du site">
            </a>
        </div>
        
        <div>
            <a href="">Accueil</a>
            <a href="index.php?action=listFilms">Films</a>
            <a href="index.php?action=listActeurs">Acteurs</a>
            <a href="index.php?action=listActeurs">Réalisateurs</a>
        </div>

        <div>
            <form method="get" action="index.php" style=" ">
                <input 
                    type="" 
                    name="action" 
                    value=""
                >
                <input 
                    type="text" 
                    name="" 
                    placeholder="Rechercher un film, un acteur, ..." 
                    required
                >
                <button type="submit">Rechercher</button>
            </form>
        </div>

        <div>
            <a href="">Membre</a>
            <a href="">Se connecter</a>
            <a href="">Créer un compte</a>
        </div>

    </head>

    <main>
        <h1>PDO Cinema</h1>
        <h2><?= $titre_secondaire ?></h2>
        <?= $contenu ?>
    </main>

    <footer>

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