Sujet :
    Réalisez les requêtes SQL suivantes avec HeidiSQL ou PhpMyAdmin
    (rédigez les requêtes dans un fichier .sql afin de garder un historique de celles-ci) :
    entre parenthèses les champs servant de référence aux requêtes.

        a. Informations d’un film (id_film) : titre, année, durée (au format HH:MM) et réalisateur 

            -- Sélection du titre, de l’année de sortie, et de la durée convertie au format HH:MM
            -- SEC_TO_TIME transforme les minutes en format heures:minutes:secondes
            SELECT f.titre,
                f.annee,
                SEC_TO_TIME(f.duree * 60),
                p.nom,
                p.prenom

            -- La table "film" est abrégée par "f" pour écrire plus court
            FROM film f

            -- Jointure entre "film" et "realisateur" pour récupérer le réalisateur de chaque film
            -- On relie grâce à la clé étrangère "id_realisateur" dans la table film
            INNER JOIN realisateur r ON f.id_realisateur = r.id_realisateur

            -- Jointure entre "realisateur" et "personne" pour accéder aux infos personnelles du réalisateur
            -- Le champ "id_personne" relie la personne au réalisateur
            INNER JOIN personne p ON p.id_personne = r.id_personne;

        b. Liste des films dont la durée excède 2h15 classés par durée (du + long au + court)


            -- Sélection du titre du film et de la durée convertie au format HH:MM:SS
            -- SEC_TO_TIME permet de convertir les minutes en heures:minutes:secondes
                SELECT f.titre,
                    SEC_TO_TIME(f.duree * 60)

            -- Utilisation de la table "film" abrégée par "f"
                FROM film f

            -- Filtre pour ne garder que les films dont la durée est supérieure ou égale à 135 minutes (2h15)
                WHERE f.duree >= 135

            -- Tri des résultats par durée décroissante (du plus long au plus court)
                ORDER BY f.duree DESC;

        c. Liste des films d’un réalisateur (en précisant l’année de sortie)

            -- Sélection du nom et prénom du réalisateur, du titre du film, et de l’année de sortie
            SELECT p.nom, p.prenom,
                f.titre,
                f.annee_sortie

            -- Utilisation de la table "film" abrégée par "f"
            FROM film f

            -- Jointure entre "film" et "realisateur" via le champ "id_realisateur"
            INNER JOIN realisateur r ON f.id_realisateur = r.id_realisateur

            -- Jointure entre "realisateur" et "personne" pour afficher les infos du réalisateur
            INNER JOIN personne p ON r.id_personne = p.id_personne

            -- Classement des films par réalisateur, puis par année de sortie
            ORDER BY p.nom, f.annee_sortie;
            -- Et non pas (Where)

        d. Nombre de films par genre (classés dans l’ordre décroissant)

       
            SELECT 
                g.nom_genre, -- Nom du genre
                COUNT(*) AS nb_films  -- Nombre de films dans ce genre (et renommer nb_films avec l'alias)
            FROM genre g  -- Table des genres (alias g)
            LEFT JOIN appartenir a 
                ON g.id_genre = a.id_genre  -- Lien entre genre et film via la table d’appartenance
            LEFT JOIN film f 
                ON a.id_film = f.id_film    -- Lien entre appartenance et film
            GROUP BY 
                g.nom_genre  -- Regrouper par genre pour les agréger
            ORDER BY 
                nb_films DESC;  -- Trier par nombre de films, décroissant

                -- RAPPEL PEDAGOGIQUE :
                -- Dans notre cas on utilise LEFT JOIN car on veut afficher TOUS les genres,
                -- même ceux qui n'ont AUCUN film associé dans la table "appartenir".
                -- La table "genre" est la table de GAUCHE (on part d'elle),
                -- la table "appartenir" est celle de DROITE (on la relie).
                -- Le LEFT JOIN garde toutes les lignes de gauche (les genres),
                -- et complète avec les films trouvés à droite (dans "appartenir"),
                -- ou NULL s’il n’y en a pas. Cela permet de compter aussi les genres à 0 film.

        e. Nombre de films par réalisateur (classés dans l’ordre décroissant)

        f. Casting d’un film en particulier (id_film) : nom, prénom des acteurs + sexe

        g. Films tournés par un acteur en particulier (id_acteur) avec leur rôle et l’année de sortie 
        (du film le plus récent au plus ancien)

        h. Liste des personnes qui sont à la fois acteurs et réalisateurs

        i. Liste des films qui ont moins de 5 ans (classés du plus récent au plus ancien)

        j. Nombre d’hommes et de femmes parmi les acteurs

        k. Liste des acteurs ayant plus de 50 ans (âge révolu et non révolu)

        l. Acteurs ayant joué dans 3 films ou plus



