<?php

// Cette classe se trouve dans le dossier “model”, (On dit que la classe Connect appartient au “dossier” Model) ???
namespace Model;
// Cela nous permettra d’écrire ensuite “use Model\Connect;” dans d’autres fichiers.


// On déclare la classe Connect comme “abstract”. 
// Abstract signifie qu’on ne pourra jms faire : new Connect();
// Cette classe sert uniquement à fournir une méthode pour se connecter à la base,
// pas à créer des objets issus de Connect.
abstract class Connect {
// (Ces constantes définissent les informations de connexion : hôte, nom de la base, utilisateur, mot de passe)
    const HOST = "localhost"; // Adresse du serveur de base ( mais nous on est en en local)
    const DB   = "cinema_pa"; // C'est le nom de notre de la base de données
    const USER = "root"; // Nom d’utilisateur pour se connecter ?,
    const PASS = "root"; // Mot de passe pour se connecter

    // Méthode: une fonction statique qui crée et renvoie un objet PDO pour la connexion
    // Pourquoi static ? 
    public static function seConnecter() { 
        try {
            return new \PDO(
                "mysql:host=" . self::HOST . ";dbname=" . self::DB . ";charset=utf8",
                self::USER,
                self::PASS
            );
        } catch (\PDOException $ex) {
            return $ex->getMessage();
        }
    }
}

// Un PDO est une extenison PHP  qui permet de se connecter à une base de données (MySQL, SQLite, PostgreSQL, etc.)
// Pourquoi static ? "static veut dire que la méthode (ou la propriété) appartient directement à la classe elle-même,
//  et non à un objet créé à partir de cette classe."
