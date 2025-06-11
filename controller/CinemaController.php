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
         require  "view/listFilms.php"; 
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
            require "view/listGenre.php";
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
      require "/../view/listRealisateurs.php";
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
      require "/view/listRoles.php";
}

    /**s
     * Lister les acteurs
     */
    public function listActeurs() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT
                p.nom,
                p.prenom
            FROM personne AS p
            INNER JOIN acteur AS a
                ON a.id_personne = p.id_personne
            ORDER BY
                p.nom ASC,
                p.prenom ASC
        ");
        require __DIR__ . "/../view/listActeurs.php";
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
       INNER JOIN personne AS p ON a.id_personne = p.id_personne
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
       INNER JOIN film   AS f ON j.id_film = f.id_film
       INNER JOIN role   AS r ON j.id_role = r.id_role
        WHERE j.id_acteur = :id
        ORDER BY f.titre ASC
    ");
    $requeteFilms->execute([ "id" => $id ]);

      require __DIR__ . "/../view/detailActeur.php";
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
        INNER JOIN appartenir AS a ON f.id_film = a.id_film
        WHERE a.id_genre = :id
        ORDER BY f.titre ASC
    ");
    $requeteFilms->execute([ "id" => $id ]);

  
      require __DIR__ . "/../view/detailGenre.php";
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
        INNER JOIN appartenir AS a ON g.id_genre = a.id_genre
        WHERE a.id_film = :id
    ");
    $requeteGenres->execute([ "id" => $id ]);

    // Charger la vue 
    require "/view/detailFilm.php";
}


//Fonction pour ajouter un genre en base de donnée
    public function insertGenre(){

        $nomGenre = filter_input(INPUT_POST, "nomGenre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

         $pdo = Connect::seConnecter();
           $addGenre  = $pdo->prepare("
                INSERT INTO genre (nom_genre)
                VALUES (:nom)
    ");
    $addGenre ->execute([ "nom" => $nomGenre ]);

    header("Location: index.php?action=listGenres");
    exit;
}

/**
 * Ajouter une personne puis un acteur
 */
public function insertActor() {

    $nomActeur     = filter_input(INPUT_POST, "nomActeur",     FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $prenomActeur  = filter_input(INPUT_POST, "prenomActeur",  FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $dateNaissance = filter_input(INPUT_POST, "dateNaissance", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $sexeActeur    = filter_input(INPUT_POST, "sexeActeur",    FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $pdo = Connect::seConnecter();


    $insertPersonne = $pdo->prepare("
        INSERT INTO personne (nom, prenom, date_naissance, sexe)
        VALUES (:nom, :prenom, :date_naissance, :sexe)
    ");
    $insertPersonne->execute([
        "nom"            => $nomActeur,
        "prenom"         => $prenomActeur,
        "date_naissance" => $dateNaissance,
        "sexe"           => $sexeActeur
    ]);


    $nouvellePersonneId = $pdo->lastInsertId();


    $nouvellePersonne = $pdo->prepare("
        INSERT INTO acteur (id_personne)
        VALUES (:id_personne)
    ");
    $nouvellePersonne->execute([ "id_personne" => $nouvellePersonneId ]);

    header("Location: index.php?action=listActeurs");
    exit;
}

/**
 * Supprimer un acteur
 */
public function deleteActor($id)
{
    $pdo = Connect::seConnecter();
    $delete = $pdo->prepare("
        DELETE FROM acteur
        WHERE id_acteur = :id
    ");
    $delete->execute([ "id" => $id ]);

    header("Location: index.php?action=listActeurs");
    exit;
}


    /**
     * Ajouter un nouveau film
     */
    public function insertFilm() {
      
        $titreFilm    = filter_input(INPUT_POST, "titreFilm", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $anneeSortie  = filter_input(INPUT_POST, "anneeSortie", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $duree        = filter_input(INPUT_POST, "duree", FILTER_SANITIZE_NUMBER_INT);
        $synopsis     = filter_input(INPUT_POST, "synopsis", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $note         = filter_input(INPUT_POST, "note", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $affiche      = filter_input(INPUT_POST, "affiche", FILTER_SANITIZE_URL);

      
        $pdo = Connect::seConnecter();

    
        $ajoutFilm = $pdo->prepare("
            INSERT INTO film
                (titre, annee_sortie, duree, synopsis, note, affiche)
            VALUES
                (:titre, :annee_sortie, :duree, :synopsis, :note, :affiche)
        ");
        $ajoutFilm->execute([
            "titre"         => $titreFilm,
            "annee_sortie"  => $anneeSortie,
            "duree"         => $duree,
            "synopsis"      => $synopsis,
            "note"          => $note,
            "affiche"       => $affiche
        ]);


        header("Location: index.php?action=listFilms");
        exit;
    }



}