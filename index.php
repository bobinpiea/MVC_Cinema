<?php


// On récupère l’ID passé dans l’URL grace à Get (ou null si rien n’est envoyé)
$id = isset($_GET["id"]) ? $_GET["id"] : null;

// ici, on indique qu’on va utiliser la classe CinemaController qui est dans le dossier Controller
use Controller\CinemaController;


// ici, on enregistre une fonction qui se charge de charger automatiquement les classes ds qu’on en a besoin
// Son fonctionnement ? 
spl_autoload_register(function ($class_name) {
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class_name) . '.php';
    if (file_exists($path)) {
        include $path;
    } else {
        echo "Fichier introuvable : $path<br>";
    }
});

// (On crée une nouvelle instance (un objet) de CinemaController pour pouvoir appeler ses méthodes
$ctrlCinema = new CinemaController();

  // (Si l’URL contient un paramètre “action”, on regarde sa valeur pour choisir quoi faire)
if (isset($_GET["action"])) {
    switch ($_GET["action"]) {

// Cas 1 : Si action=listFilms, on appelle la méthode listFilms du controller)
        case "listFilms":
            $ctrlCinema->listFilms();
            break;

 // (Si action=listActeurs, on appelle la méthode listActeurs du controller)
        case "listActeurs":
            $ctrlCinema->listActeurs();
            break;

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
        $ctrlCinema->insertActor(["nom"],["prenom"],["dateNaissance"], ["sexe"]); // ???????
        break;
    }
}