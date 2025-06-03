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
    public function listFilms() { // On déclare une fonction listFilms qui va récupérer et afficher tous les films
    // On appelle la méthode seConnecter de la classe Connect pour établir la connexion à la bbdd
     $pdo = Connect::seConnecter();
    // CI-dessous, on exécute une requête SQL : on sélectionne les colonnes/champs titre et annee_sortie dans la table film
        $requete = $pdo->query("    //  et on stocke le résultat dans la variable $requete)
             SELECT titre, annee_sortie
             FROM film
         ");

    //(On inclut le fichier view/listFilms.php qui va utiliser $requete pour afficher la liste des films)
        require "view/listFilms.php"; 
    }



    /** A Rajouter ou pas ? 
     * Lister les acteurs
     */
    public function listActeurs()
    {
       $pdo = Connect::seConnecter();
     $requete = $pdo->query("
             SELECT nom, prenom
             FROM acteurs
         ");

         require "view/listActeurs.php";
    }
}