<?php

    // Le ? veut dire "si c’est vrai alors je fais ça", sinon "je fais ça"
    // Si l’id est dans l’URL, on le récupère
    // sinon, on met null
$id = isset($_GET["id"]) ? $_GET["id"] : null;
    // C'est une expression ternaire (il faut que je me renseigne)
    // Mais en somme, elle permet de faire le if, plus rapidement 

    // ici, on indique qu'on va utiliser la classe CinemaController, qui est rangée dans le "namespace" Controller, (ce-dernier est généralement associé au dossier controller)
use Controller\CinemaController;
    //  Namespace : Un namespace permet de classer les classes dans des dossiers logiques
    // pour éviter d'éventuel conflits eentre différentes class et mieux organiser le projet. 
    //(Métaphore : Le namespace, c’est comme un nom de famille pour les classes. Ça permet d’éviter les confusions si plusieurs classes ont le même nom.)


    // ici, on enregistre une fonction qui se charge de charger automatiquement les classes dès qu’on en a besoin
spl_autoload_register(function ($class_name) {
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class_name) . '.php';
    if (file_exists($path)) {
        include $path;
    } else {
        echo "Fichier introuvable : $path<br>";
    }
});

    // Je crée un objet à partir de la classe CinemaController = Instanciation
    // Cet objet va me permettre d’appeler ses méthodes (listFilms, listActeurs, etc...)
$ctrlCinema = new CinemaController();


// Si j’écris juste index.php sans rien derrière (sans ?action=...), 
// alors il ne sait pas quoi afficher → on choisit par défaut la page d’accueil
// Donc : si y a pas de paramètre "action" dans l’URL, 
// alors on le force à devenir "accueil", comme ça on a une page par défaut
//( Ici on vérifie si aucune action n’a été envoyée dans l’URL.
// Le point d’exclamation veut dire "si ce n’est pas défini".
// Donc si l’utilisateur n’a rien précisé (pas de ?action=...), alors on affiche la page d’accueil par défaut.)
// Du coup on définit l’action nous-même comme "accueil", pour qu’il tombe directement sur la page d’accueil.
if (!isset($_GET["action"])) {
    $_GET["action"] = "accueil";
}

    // On vérifie si une action a été envoyée dans l’URL (ex: ?action=listFilms), si c'est le cas, on va réagir en conséquence 
if (isset($_GET["action"])) {

        // On utilise switch pour tester la valeur de "action" dans l’URL
        // et appeler la méthode correspondante dans le contrôleur
    switch ($_GET["action"]) {

            // ex : Cas 1 : Si action=listFilms, on appelle la méthode listFilms du controller) 
            // et j'applique la meme logique pour la suite des autres "case"
        case "listFilms":
            $ctrlCinema->listFilms();
        break;

            // (Si action=listActeurs, on appelle la méthode listActeurs du controller)
        case "listActeurs":
            $ctrlCinema->listActeurs();
        break;

            // On appelle la méthode detailFilm en lui donnant l’ID du film pour qu’elle affiche ses infos : 
            
            /*
                On appelle ici la méthode detailFilm du contrôleur cinéma.
                On lui transmet en paramètre l’ID du film, qu’on a récupéré depuis l’URL avec $_GET["id"].
                Cet ID va servir à la méthode pour aller chercher dans la base de données
                le film correspondant à cet identifiant.
                Ensuite, cette méthode affichera tous les détails du film dans la vue prévue pour cela.
            */
            
        case "detailFilm":
            $ctrlCinema->detailFilm($id);
        break;

        case "listGenres":
            $ctrlCinema->listGenres();
        break;

        case "listRealisateurs":
            $ctrlCinema->listRealisateurs();
        break;

        case "listRoles":
            $ctrlCinema->listRoles();
        break;

        case "detailActeur":
            $ctrlCinema->detailActeur($id);
        break;

        case "detailGenre":
            $ctrlCinema->detailGenre($id);
        break;

        case "insertGenre":
            $ctrlCinema->insertGenre();
        break;

        case "insertActor":
            $ctrlCinema->insertActor(
                $_POST["nomActeur"],
                $_POST["prenomActeur"],
                $_POST["dateNaissance"],
                $_POST["sexeActeur"]
            );
        break;
        
        case "deleteActor":
            $ctrlCinema->deleteActor($id);
        break;


        case "insertFilm":
            $ctrlCinema->insertFilm(
                $_POST["titreFilm"],
                $_POST["anneeSortie"],
                $_POST["duree"],
                $_POST["synopsis"],
                $_POST["note"],
                $_POST["affiche"]
            );
        break;

        case "insertRealisateur":
            $ctrlCinema->insertRealisateur(
                $_POST["nomRealisateur"],
                $_POST["prenomRealisateur"],
                $_POST["dateNaissanceRealisateur"],
                $_POST["sexeRealisateur"]
            );
        break;

        case "accueil":
                $ctrlCinema->afficherAccueil();
            break;

       
    // AJOUT DES CAS DE SUPPRESSION : 

        //Suppression de film
            case "deleteFilm":
                $ctrlCinema->deleteFilm($id);
            break;

        //Suppression d'acteur
            case "deleteActeur":
                $ctrlCinema->deleteActeur($id);
            break;
        
        //Suppresion Réalisateur
            case "deleteRealisateur":
                $ctrlCinema->deleteRealisateur();
            break;
            
    }
}