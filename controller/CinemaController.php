<?php // On ouvre le bloc de code PHP

    /** RAPPEL 
     * Le contrôleur reçoit une demande (ex : afficher les films),
     * il va chercher les infos nécessaires (dans le modèle),
     * et il les transmet à la vue pour les afficher.
     */

// On indique qu’on est dans le “dossier” Controller : ça dit où se trouve cette classe
    namespace Controller;

// J’importe la classe Connect depuis le namespace Model pour pouvoir l’utiliser ici (et par conséquent me connecter la bdd)
    use Model\Connect;

// on déclare la classe CinemaController
// Cette dernière contiendra les méthodes pour gérer les actions du site (films, acteurs, etc.)
    class CinemaController {

        /* AFFICHER LA PAGE D'ACCUEIL */
        
                // Cette méthode affiche la page d’accueil
                public function afficherAccueil() {
                    require "view/accueil.php";
                }

        /* METHODE POUR LES LISTES */

            // Lister les films

                // Méthode appelée quand l’action "listFilms" est demandée dans l’URL
                // Elle va récupérer les films et afficher la vue correspondante
                    public function listFilms() { 
                                // On appelle la méthode seConnecter de la classe Connect pour établir la connexion à la bbdd
                            $pdo = Connect::seConnecter();
                                // Ci-dessous, on exécute une requête SQL : on sélectionne les colonnes/champs 
                                // titre et annee_sortie dans la table film
                                // et on stocke cela dans la variable requete
                            $requete = $pdo->query("     
                                SELECT id_film, titre, annee_sortie 
                                FROM film
                            ");


                            // Utilisation de Query car on ne passe pas de variable, on récupère tous les genres 
                            // et on les affiches et le résultat est stocké dans la variable genre
                        $genres = $pdo->query("
                            SELECT id_genre, nom_genre 
                            FROM genre 
                            ORDER BY nom_genre ASC
                        ");

                        $realisateurs = $pdo->query("
                                SELECT
                                    r.id_realisateur,
                                    p.nom,
                                    p.prenom
                                FROM personne p
                                INNER JOIN realisateur r ON  r.id_personne = p.id_personne
                                ORDER BY p.nom ASC
                            ");

                            /**
                             *  C'est quoi query ? 
                             *  query() est une fonction fournie par PDO qui permet d’envoyer directement une requête SQL
                             *  à la base de données, quand il n’y a pas de variable dedans.
                             *  on l'utilise quand c'est qlq ch de "fixe"
                             */ 
                
                            //(On inclut le fichier view/listFilms.php qui va utiliser $requete pour afficher la liste des films)
                        require  "view/listFilms.php"; 
                    }

            // Lister les genres

                // cette méthode est appelée quand l’action est "listGenres" est demandée dans l’URL
                // Elle va récupérer les genres et afficher la vue correspondant
                    public function listGenres() {
                            // On appelle la méthode seConnecter de la classe Connect pour établir la connexion à la bbdd
                        $pdo = Connect::seConnecter();
                            // Ci-dessous, on exécute une requête SQL : on sélectionne id_genre et 
                            // le nom de chaque genre (ex: action, aventure ...)  de la table genre -  ensuite on les classe
                            // et on stocke cela dans la variable requete
                        $requete = $pdo->query("
                            SELECT id_genre, nom_genre
                            FROM genre
                            ORDER BY nom_genre ASC
                        ");
                        // On inclut le fichier view/listGenre.php qui va utiliser $requete pour afficher la liste des genres
                        require "view/listGenre.php";
                    }

            // Lister les réalisateurs
            
                // Cette méthode sert à afficher tous les réalisateurs
                // Elle est appelée quand dans l’URL on a ?action=listRealisateurs
                    public function listRealisateurs() {

                        // Connexion à la base de données
                        $pdo = Connect::seConnecter();

                        // Je lance une requête pour récupérer les noms et prénoms des réalisateurs
                        // Pour ça, je prends les personnes qui ont un lien dans la table "realisateur"
                        // donc je fais une jointure entre personne et realisateur
                        $realisateurs = $pdo->query("
                            SELECT r.id_realisateur, p.nom, p.prenom
                            FROM personne p
                            INNER JOIN realisateur r ON r.id_personne = p.id_personne
                            ORDER BY p.nom ASC
                        ");

                        // Une fois que j’ai récupéré tous les réalisateurs,
                        // je les envoie dans une page spéciale (vue) pour les afficher à l’écran
                        require "view/listRealisateurs.php";
                    }

            // Lister les roles 

                // Ici l'objectif est de lister toutes les roles 
                    public function listRoles() {
                        $pdo = Connect::seConnecter();
                        $requete = $pdo->query("
                            SELECT 
                                r.id_role,
                                r.nom_role,
                                r.sexe_role
                            FROM role r
                            ORDER BY r.nom_role ASC
                        ");
                        require "/view/listRoles.php";
                    }

            // Lister les acteurs

                public function listActeurs() {
                    $pdo = Connect::seConnecter();
                    $requete = $pdo->query("
                        SELECT
                            a.id_acteur, 
                            p.nom,
                            p.prenom
                        FROM personne p
                        INNER JOIN acteur a
                            ON a.id_personne = p.id_personne
                        ORDER BY
                            p.nom ASC,
                            p.prenom ASC
                    ");
                    require __DIR__ . "/../view/listActeurs.php";
                }

        /* AFFICHER LES DETAILS */

            // Les détails des Acteurs 
        
                public function detailActeur($id){
                        // On se connecte à la base de données grâce à notre méthode seConnecter()
                    $pdo = Connect::seConnecter();
                        // On prépare une requête SQL pour demander un film à la base
                        // On ne connaît pas encore l’id exact du film, alors on met une étiquette ":id"
                        // On utilise prepare() pour dire à PHP : je te donne le plan de ma requête, mais je te donne la valeur plus tard
                        // On ne met pas directement la valeur car elle vient de l’utilisateur (URL), donc on protège avec prepare()
                    $requetePers = $pdo->prepare("
                        SELECT
                            p.id_personne,
                            p.nom,
                            p.prenom
                        FROM acteur a
                        INNER JOIN personne p ON a.id_personne = p.id_personne
                        WHERE a.id_acteur = :id
                    ");
                        // On exécute  la requête qu’on avait préparée plus haut
                        // On donne à PHP la vraie valeur de id à mettre dans la requête SQL
                        // On dit : remplace :id par la valeur de $id
                        // "id" est le nom du paramètre qu’on avait dans la requête SQL (:id)
                        // $id est la vraie valeur qu’on a récupérée (par exemple depuis l’URL)
                    $requetePers->execute([ "id" => $id ]);

                    
                    $requeteFilms = $pdo->prepare("
                        SELECT
                            f.id_film,
                            f.titre,
                            j.id_role,
                            r.nom_role
                        FROM jouer j
                        INNER JOIN film f ON j.id_film = f.id_film
                        INNER JOIN role r ON j.id_role = r.id_role
                        WHERE j.id_acteur = :id
                        ORDER BY f.titre ASC
                    ");
                    $requeteFilms->execute([ "id" => $id ]);
                  
                    require __DIR__ . "/../view/detailActeur.php"; 
                }

            // Afficher le détail d'un genre (nom et films associés)

                public function detailGenre($id) {

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

            // Afficher les détail d'un film 

                    public function detailFilm($id){
                        // On se connecte à la base de données grâce à notre méthode seConnecter()
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
                        require "/view/detailFilms.php";
                    }
 
    /* LES METHODES D'AJOUT */

        // Fonction pour ajouter un genre en base de donnée

                    public function insertGenre(){

                        $nomGenre = filter_input(INPUT_POST, "nomGenre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                        $pdo = Connect::seConnecter();
                        $addGenre = $pdo->prepare("
                            INSERT INTO genre (nom_genre)
                            VALUES (:nom)
                         ");
                        $addGenre ->execute([ "nom" => $nomGenre ]);

                        header("Location: index.php?action=listGenres");
                    exit;
                    }

        // Ajouter une personne et par ricochet un acteur

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

        // Insérer un film
                        
                        public function insertFilm() {

                            // L’objectif ici c’est de récupérer toutes les données envoyées depuis le formulaire HTML
                            // Donc ici on récupère : le titre, l’année de sortie, la durée, le synopsis, la note, l’affiche, et le réalisateur
                            // On filtre en fonction des données que l'on souhaite recevoi
                            $titreFilm    = filter_input(INPUT_POST, "titreFilm", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                            $anneeSortie  = filter_input(INPUT_POST, "anneeSortie", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                            $duree        = filter_input(INPUT_POST, "duree", FILTER_SANITIZE_NUMBER_INT);
                            $synopsis     = filter_input(INPUT_POST, "synopsis", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                            $note         = filter_input(INPUT_POST, "note", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

                                $posterPath = "public/img/upload_movies/default.webp"; // Le chemin local ou seront stockés les img par défaut
                                        // Si un fichier a été envoyé dans le champ "affiche" ET qu’il n’y a pas eu d’erreur
                                            
                                        if (isset($_FILES['affiche']) && $_FILES['affiche']['error'] === 0) {                                                
                                                // On récupère le chemin temporaire de l’image envoyée
                                                $tmpName = $_FILES['affiche']['tmp_name'];
                                                // On récupère le vrai nom du fichier (ex : image.jpg)
                                                $name = $_FILES['affiche']['name'];
                                                // On récupère la taille du fichier en octets
                                                $size = $_FILES['affiche']['size'];

                                                $error = $_FILES['affiche']['error']; //
                                                $type = $_FILES['affiche']['type']; // 

                                                 // On coupe le nom à partir du point pour isoler l'extension (ex : ["image", "wbep"])
                                                 // (Explode : Scinde une chaîne de caractères en segments)
                                                $tabExtension = explode('.', $name);
                                                 // On prend juste l’extension, on la met en minuscule (ex : jpg)
                                                $extension = strtolower(end($tabExtension));
                                                // On définit quelles extensions sont autorisées (Tableau des extensions qu'on autorise)
                                                $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                                                // Taille maximale autorisée 
                                                $maxSize = 100000000; 

                                                // Si le type de fichier est autorisé ET que sa taille est correcte 
                                                if (in_array($extension, $allowedExtensions) && $size <= $maxSize) {
                                                    // On crée un nom (identifiant ? ) unique pour éviter d’écraser une autre image
                                                    $uniqueName = uniqid('', true);
                                                     // On (re)construit le nom du fichier avec l’extension 
                                                    $fileName = $uniqueName . '.' . $extension;
                                                    // Le chemin complet où sera stockée l’image (avant conversion en webp)
                                                    $destination = "public/img/upload_movies/" . $fileName;

                                                    // On déplace le fichier depuis le dossier temporaire vers notre dossier
                                                    move_uploaded_file($tmpName, $destination);

                                                    // Convertir en webp
                                                    $image = imagecreatefromstring(file_get_contents($destination));
                                                     // Nouveau chemin final pour le fichier converti en webp
                                                    $webpPath = "public/img/upload_movies/" . $uniqueName . ".webp";
                                                    // On convertit l’image en .webp et on la sauvegarde au bon endroit
                                                    imagewebp($image, $webpPath);
                                
                                                    // On supprime l’image d’origine (jpg, png...) pour ne pas garder de doublon
                                                    unlink($destination);
                                                    $posterPath = $webpPath;  
                                                    } else {
                                                    echo " L'image n'a pas pu être téléchargée : format invalide ou fichier trop lourd.";
                                                }
                                        }      
                                        

                            $realisateur  = filter_input(INPUT_POST, "id_realisateur", FILTER_SANITIZE_NUMBER_INT);

                            // Connexion à la base de données
                            $pdo = Connect::seConnecter();

                            // Préparation de la requête SQL pour insérer un film dans la table "film"
                            $ajoutFilm = $pdo->prepare("
                                INSERT INTO film (titre, annee_sortie, duree, synopsis, note, affiche, id_realisateur)
                                VALUES (:titre, :annee_sortie, :duree, :synopsis, :note, :affiche, :id_realisateur)
                            ");

                           //var_dump($realisateur);
                           //die();

                            // Exécution de la requête SQL avec les données récupérées du formulaire
                            $ajoutFilm->execute([
                                "titre"          => $titreFilm,
                                "annee_sortie"   => $anneeSortie,
                                "duree"          => $duree,
                                "synopsis"       => $synopsis,
                                "note"           => $note,
                                "affiche"        => $posterPath, // maintenant ca sera une imaga en  .wbep 
                                "id_realisateur" => $realisateur
                            ]);

                            // Une fois que le film est bien ajouté, on redirige vers la liste des films
                            header("Location: index.php?action=listFilms");
                            exit; 
                        }
                    
                

        // Ajouter un réalisateur
                        public function insertRealisateur() {
                            // 
                            $nomRealisateur         = filter_input(INPUT_POST, "nomRealisateur",         FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                            $prenomRealisateur      = filter_input(INPUT_POST, "prenomRealisateur",      FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                            $dateNaissanceRealisateur = filter_input(INPUT_POST, "dateNaissanceRealisateur", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                            $sexeRealisateur        = filter_input(INPUT_POST, "sexeRealisateur",        FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                            //
                            $pdo = Connect::seConnecter();

                            //
                            $requeteInsertPersonne = $pdo->prepare("
                                INSERT INTO personne (nom, prenom, date_naissance, sexe)
                                VALUES (:nom, :prenom, :date_naissance, :sexe)
                            ");
                            $requeteInsertPersonne->execute([
                                "nom"            => $nomRealisateur,
                                "prenom"         => $prenomRealisateur,
                                "date_naissance" => $dateNaissanceRealisateur,
                                "sexe"           => $sexeRealisateur
                            ]);

                            // 
                            $nouvelIdPersonne = $pdo->lastInsertId();

                            // 
                            $requeteInsertRealisateur = $pdo->prepare("
                                INSERT INTO realisateur (id_personne)
                                VALUES (:id_personne)
                            ");
                            $requeteInsertRealisateur->execute([
                                "id_personne" => $nouvelIdPersonne
                            ]);

                            // 
                            header("Location: index.php?action=listRealisateurs");
                            exit;
                        }
  
    /* LES METHODES DE SUPPRESSION */

        // Supprimer un acteur
                public function deleteActeur($id) {

                    // 
                        $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

                    // Sert à se connecter à la base de données
                        $pdo = Connect::seConnecter();

                        $delete = $pdo->prepare("
                            DELETE FROM acteur
                            WHERE id_acteur = :id
                            ");
                                
                        $delete->execute([ "id" => $id ]);

                    header("Location: index.php?action=listActeurs");
                    exit;
                }       

        // Supprimer un réalisateur
            public function deleteRealisateur($id) {
                // 
                    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

                // Connexion à la base de données
                    $pdo = Connect::seConnecter();

                //
                    $delete = $pdo->prepare("
                        DELETE FROM realisateur 
                        WHERE id_realisateur = :id
                    ");

                // Exécution de la requête avec la valeur de l’id
                    $delete->execute(["id" => $id]);

                // Une fois supprimé, on revient à la page liste des réalisateurs
                    header("Location: index.php?action=listRealisateurs");
                    exit;
            }

        // Supprimer un film
            public function deleteFilm($id) {
                //
                    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

                // Connexion à la base de données
                    $pdo = Connect::seConnecter();

                //
                    $delete = $pdo->prepare("
                        DELETE FROM film 
                        WHERE id_film = :id
                    ");
                
                //
                    $delete->execute(["id" => $id]);

                // Redirection vers la liste des films après suppression
                    header("Location: index.php?action=listFilms");
                    exit;
            }


}