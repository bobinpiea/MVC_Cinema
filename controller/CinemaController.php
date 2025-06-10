<?php // On ouvre le bloc de code PHP

// On indique qu’on est dans le “dossier” Controller : ça dit où se trouve cette classe,
namespace Controller;
// On indique qu’on va utiliser la classe Connect, qui se trouve dans le dossier Model 
use Model\Connect;

// (On crée une classe nommée CinemaController, qui va contenir les méthodes pour gérer les films (et acteurs)
class CinemaController {
    /**
     * Lister les films
     */
    public function listFilms() { // On déclare une fonction listFilms qui a pour role de récupérer et afficher tous les films
    // On appelle la méthode seConnecter de la classe Connect pour établir la connexion à la bbdd
     $pdo = Connect::seConnecter();
    // Ci-dessous, on exécute une requête SQL : on sélectionne les colonnes/champs titre et annee_sortie dans la table film
         $requete = $pdo->query("     
             SELECT titre, annee_sortie 
             FROM film
          ");
   
    //(On inclut le fichier view/listFilms.php qui va utiliser $requete pour afficher la liste des films)
        require "view/listFilms.php"; 
    }


        /**
         * Lister tous les genres
         */
        public function listGenres()
        {
            $pdo = Connect::seConnecter();
            $requete = $pdo->query("
                SELECT id_genre, nom_genre
                FROM genre
                ORDER BY nom_genre ASC
            ");
            require __DIR__ . "/../view/listGenres.php";
        }



    /**
     * Lister tous les réalisateurs
     */
    public function listRealisateurs()
    {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT 
                p.id_personne,
                p.nom,
                p.prenom
            FROM realisateur AS r
            JOIN personne    AS p ON r.id_personne = p.id_personne
            ORDER BY p.nom ASC, p.prenom ASC
        ");
        require  "/../view/listRealisateurs.php";
    }

    /**
 * Lister tous les rôles
 */
public function listRoles()
{
    $pdo = Connect::seConnecter();
    $requete = $pdo->query("
        SELECT 
            id_role,
            nom_role,
            sexe_role
        FROM role
        ORDER BY nom_role ASC
    ");
    require "/../view/listRoles.php";
}


/**
 * Afficher le détail d’un acteur : ses infos et les films où il joue
 */
public function detailActeur($id)
{
    $pdo = Connect::seConnecter();

 
    $requetePers = $pdo->prepare("
        SELECT
            p.id_personne,
            p.nom,
            p.prenom
        FROM acteur AS a
        JOIN personne AS p ON a.id_personne = p.id_personne
        WHERE a.id_acteur = :id
    ");
    $requetePers->execute([ "id" => $id ]);

    
    $requeteFilms = $pdo->prepare("
        SELECT
            f.id_film,
            f.titre,
            j.id_role,
            r.nom_role
        FROM jouer AS j
        JOIN film   AS f ON j.id_film = f.id_film
        JOIN role   AS r ON j.id_role = r.id_role
        WHERE j.id_acteur = :id
        ORDER BY f.titre ASC
    ");
    $requeteFilms->execute([ "id" => $id ]);

    require "/../view/detailActeur.php";
}

/**
 * Afficher le détail d’un genre : nom et films associés
 */
public function detailGenre($id)
{
    $pdo = Connect::seConnecter();

    $requeteGenre = $pdo->prepare("
        SELECT
            id_genre,
            nom_genre
        FROM genre
        WHERE id_genre = :id
    ");
    $requeteGenre->execute([ "id" => $id ]);


    $requeteFilms = $pdo->prepare("
        SELECT
            f.id_film,
            f.titre,
            f.annee_sortie
        FROM film AS f
        JOIN appartenir AS a ON f.id_film = a.id_film
        WHERE a.id_genre = :id
        ORDER BY f.titre ASC
    ");
    $requeteFilms->execute([ "id" => $id ]);

  
    require "/../view/detailGenre.php";
}

   public function detailFilm($id){
    $pdo = Connect::seConnecter();

    // Récupérer les infos de base du film
    $requeteFilm = $pdo->prepare("
        SELECT
            id_film,
            titre,
            annee_sortie,
            duree,
            synopsis,
            note,
            affiche
        FROM film
        WHERE id_film = :id
    ");

    
    $requeteGenres = $pdo->prepare("
        SELECT g.nom_genre
        FROM genre AS g
        JOIN appartenir AS a ON g.id_genre = a.id_genre
        WHERE a.id_film = :id
    ");
    $requeteGenres->execute([ "id" => $id ]);



    // Charger la vue 
    require "/view/detailFilm.php";
}


//Fonction pour ajouter un genre en base de donnée
    public function insertGenre($nomGenre){

         $pdo = Connect::seConnecter();
           $addGenre  = $pdo->prepare("
                INSERT INTO genre (nom_genre)
                VALUES (:nom)
    ");

    $insertGenre ->execute([ "nom" => $nomGenre ]);
    
    header("Location: index.php?action=listGenres");
    exit;
}







}