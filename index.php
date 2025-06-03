<?php // Balise qui sert à ouvrir le code PHP 

// On récupère l’ID passé dans l’URL (ou null s’il n’est pas présent)
$id = (isset($_GET["id"])) ? $_GET["id"] : null;

// Permet d’utiliser la classe/le fichier CinemaController qui se trouve dans le dossier Controller
use Controller\CinemaController; 

// On autocharge les classes du projet :
// On enregistre une fonction “d’autoload” qui va charger automatiquement
// la classe dès qu’on l’utilise sans l’avoir incluse manuellement.
// Le mot-clé “function” sert à déclarer une fonction anonyme (ou “callback”)
// que PHP appelle quand une classe doit être chargée.
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

// Ici, on instancie/crée l’objet du Controller Cinema 
$ctrlCinema = new CinemaController();

// isset vérifie si "action" existe dans l’URL et n’est pas null
if (isset($_GET["action"])) {
    // Selon la valeur de “action” dans l’URL, on appelle la méthode correspondante du controller
    switch ($_GET["action"]) {

        case "listFilms":
            $ctrlCinema->listFilms();
            break;

        case "listActeurs":
            $ctrlCinema->listActeurs();
            break;

        case "detailFilm":
            $ctrlCinema->detailFilm($id);
            break;

    }
}