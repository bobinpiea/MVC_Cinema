<?php

// Cette classe se trouve dans le dossier “model”, (On dit que la classe Connect appartient au “dossier” Model)
namespace Model;
// Cela nous permettra d’écrire ensuite “use Model\Connect;” dans d’autres fichiers.


// On déclare la classe Connect comme “abstract”. 
// Abstract signifie qu’on ne pourra jms faire : new Connect();
// Cette classe sert uniquement à fournir une méthode pour se connecter à la base de donnée
// pas à créer des objets issus de Connect.
abstract class Connect {
// (Ces constantes définissent les informations de connexion : hôte, nom de la base, utilisateur, mot de passe)
    const HOST = "localhost"; // Adresse du serveur de base ( mais nous on est en en local)
    const DB   = "cinema_pa"; // C'est le nom de notre de la base de données
    const USER = "root"; // Nom d’utilisateur pour se connecter ?,
    const PASS = "root"; // Mot de passe pour se connecter - Sur Mac il a fallu mettre un mot de passe 

    // Méthode statique = on peut l’appeler sans créer d’objet
    // Cette méthode servira à établir la connexion à la base de données
    public static function seConnecter() { 
         // On essaie de se connecter à la base de données
         // Si une erreur arrive, on ira dans le bloc catch
        try {
            return new \PDO(
                // On crée une connexion PDO à la base de données MySQL
                // en utilisant les constantes HOST, DB, USER et PASS
                "mysql:host=" . self::HOST . ";dbname=" . self::DB . ";charset=utf8",
                self::USER,
                self::PASS
            );
        // Si une erreur survient, on stoppe tout et on affiche le message d’erreur retourné par PDO
        } catch (\PDOException $ex) {
            return $ex->getMessage();
        }
    }
}

//  Rappel : Un PDO est une extenison PHP  qui permet de se connecter à une base de données...

