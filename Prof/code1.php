<?php

public function addMovie(): void
    {
        $session = new Session();

        if ($session->isAdmin()) {

            $pdo = Connect::toLogIn();

            $requestDirectors = $pdo->query("
        SELECT director.idDirector, person.firstname, person.surname
        FROM director
        INNER JOIN person ON director.idPerson = person.idPerson
        ORDER BY surname
        ");

            $requestThemes = $pdo->query("
        SELECT theme.idTheme, theme.typeName
        FROM theme
        ORDER BY typeName
        ");

            if (isset($_POST['submit'])) { // Vérifie si le formulaire a été soumis

                $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $releaseYear = filter_input(INPUT_POST, "releaseYear", FILTER_VALIDATE_INT);
                $duration = filter_input(INPUT_POST, "duration", FILTER_VALIDATE_INT);
                $note = filter_input(INPUT_POST, "note", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $synopsis = filter_input(INPUT_POST, "synopsis", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $director = filter_input(INPUT_POST, "idDirector", FILTER_SANITIZE_NUMBER_INT);

                if (isset($_FILES['file'])) {
                    $tmpName = $_FILES['file']['tmp_name'];
                    $name = $_FILES['file']['name'];
                    $size = $_FILES['file']['size'];
                    $error = $_FILES['file']['error'];
                    $type = $_FILES['file']['type'];

                    $tabExtension = explode('.', $name);
                    $extension = strtolower(end($tabExtension));

                    // Tableau des extensions qu'on autorise
                    $allowedExtensions = ['jpg', 'png', 'jpeg', 'webp'];
                    $maxSize = 100000000;

                    if (in_array($extension, $allowedExtensions) && $size <= $maxSize && $error == 0) {

                        $uniqueName = uniqid('', true);
                        $file = $uniqueName . '.' . $extension;

                        move_uploaded_file($tmpName, "public/img/movies/" . $file);

                        // Conversion en webp
                        // Création de mon image en doublon en chaine de caractères
                        $posterSource = imagecreatefromstring(file_get_contents("public/img/movies/" . $file));
                        // Récupération du chemin de l'image
                        $webpPath = "public/img/movies/" . $uniqueName . ".webp";
                        // Conversion en format webp
                        imagewebp($posterSource, $webpPath);
                        // Suppression de l'ancienne image
                        unlink("public/img/movies/" . $file);
                    } else {
                        echo "Wrong extension or file size too large or error !";
                    }
                }

                $poster = isset($webpPath) ? $webpPath : "public/img/movies/default.webp";

                $requestAddMovie = $pdo->prepare("
            INSERT INTO movie (title, releaseYear, duration, note, synopsis, poster, idDirector)
            VALUES (:title, :releaseYear, :duration, :note, :synopsis, :poster, :idDirector)
            ");

                $requestAddMovie->execute([
                    "title" => $title,
                    "releaseYear" => $releaseYear,
                    "duration" => $duration,
                    "note" => $note,
                    "synopsis" => $synopsis,
                    "poster" => $poster,
                    "idDirector" => $director
                ]);

                $movieId = $pdo->lastInsertId();

                foreach ($_POST['theme'] as $theme) {

                    $theme = filter_var($theme, FILTER_VALIDATE_INT);

                    $requestAddMovieTheme = $pdo->prepare("
                INSERT INTO movie_theme (idMovie, idTheme)
                VALUES(:idMovie, :idTheme)
                ");

                    $requestAddMovieTheme->execute([
                        "idMovie" => $movieId,
                        "idTheme" => $theme
                    ]);
                }

                // Redirection vers la page 'index.php?action=listMovies' après le traitement du formulaire
                header("Location:index.php?action=listMovies");
                $_SESSION['message'] = "<div class='alert'>Movie added successfully !</div>";
                exit;
            }

            require "view/movies/addMovie.php";
        } else {
            header("Location:index.php");
            exit;
        }
    }
    

?>