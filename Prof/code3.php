<?php

public function addCasting($id)
    {
        if (!Service::exists("movie", $id)) {
            header("Location:index.php");
            exit;
        } else {

            $session = new Session();
            if ($session->isAdmin()) {

                $pdo = Connect::toLogIn();

                $requestCasting = $pdo->query("
        SELECT play.idMovie, play.idActor, play.idRole
        FROM play
        ");

                $requestMovies = $pdo->prepare("
        SELECT movie.idMovie, movie.title
        FROM movie
        WHERE movie.idMovie = :id
        ");
                $requestMovies->execute(["id" => $id]);

                $requestActors = $pdo->query("
        SELECT actor.idActor, person.firstname, person.surname
        FROM actor
        INNER JOIN person ON actor.idPerson = person.idPerson
        ORDER BY person.surname
        ");

                $requestRoles = $pdo->query("
        SELECT role.idRole, role.roleName
        FROM role
        ORDER BY role.roleName
        ");

                if (isset($_POST['submit'])) {

                    $movie = filter_var($_POST['idMovie'], FILTER_VALIDATE_INT);
                    $actor = filter_var($_POST['idActor'], FILTER_VALIDATE_INT);
                    $role = filter_var($_POST['idRole'], FILTER_VALIDATE_INT);

                    $requestAddCasting = $pdo->prepare("
            INSERT INTO play (idMovie, idActor, idRole)
            VALUES (:idMovie, :idActor, :idRole)
            ");

                    $requestAddCasting->execute(["idMovie" => $movie, "idActor" => $actor, "idRole" => $role]);

                    header("Location:index.php?action=movieDetails&id=$id");
                    $_SESSION['message'] = "<div class='alert'>This person has been added to the cast successfully !</div>";
                    exit;
                }

                require "view/movies/addCasting.php";
            } else {
                header("Location:index.php");
                exit;
            }
        }
    }

?>