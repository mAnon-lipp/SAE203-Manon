<?php
/**
 * Ce fichier contient toutes les fonctions qui réalisent des opérations
 * sur la base de données, telles que les requêtes SQL pour insérer, 
 * mettre à jour, supprimer ou récupérer des données.
 */

/**
 * Définition des constantes de connexion à la base de données.
 *
 * HOST : Nom d'hôte du serveur de base de données, ici "localhost".
 * DBNAME : Nom de la base de données
 * DBLOGIN : Nom d'utilisateur pour se connecter à la base de données.
 * DBPWD : Mot de passe pour se connecter à la base de données.
 */
define("HOST", "localhost");
define("DBNAME", "lippler1");
define("DBLOGIN", "lippler1");
define("DBPWD", "lippler1");

function getMovie() {
    try {
        $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        $sql = "SELECT id, name, image FROM Movie";
        $answer = $cnx->query($sql);
        return $answer->fetchAll(PDO::FETCH_OBJ);
    } catch (Exception $e) {
        error_log("Erreur SQL : " . $e->getMessage()); // Log dans les erreurs PHP
        return false;
    }
}

function addMovie($name, $director, $year, $length, $description,$id_category, $image, $trailer, $min_age) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);

    $sql = "INSERT INTO Movie (name, director, year, length, description, id_category, image, trailer, min_age) 
            VALUES (:name, :director, :year, :length, :description, :id_category, :image, :trailer, :min_age)";

    $stmt = $cnx->prepare($sql);

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':director', $director);
    $stmt->bindParam(':year', $year);
    $stmt->bindParam(':length', $length);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':id_category', $id_category);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':trailer', $trailer);
    $stmt->bindParam(':min_age', $min_age);

    $stmt->execute();
    $res = $stmt->rowCount();
    return $res; // Retourne le nombre de lignes affectées par l'opération
}

function addProfile($name, $avatar, $min_age) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);

    $sql = "INSERT INTO Profil (name, avatar, min_age) 
            VALUES (:name, :avatar, :min_age)";

    $stmt = $cnx->prepare($sql);

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':avatar', $avatar);
    $stmt->bindParam(':min_age', $min_age);

    $stmt->execute();
    $res = $stmt->rowCount();
    return $res; // Retourne le nombre de lignes affectées par l'opération
}

function getProfiles() {
    try {
        $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // Requête SQL pour récupérer les profils
        $sql = "SELECT id, name, avatar, min_age FROM Profil";
        $stmt = $cnx->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ); // Retourne les profils sous forme d'objets
    } catch (Exception $e) {
        error_log("Erreur SQL : " . $e->getMessage());
        return false;
    }
}

function getMovieDetail($id) {
    try {
        // Connexion à la base de données
        $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // Requête SQL pour récupérer les détails du film
        $sql = "SELECT 
                    Movie.id, 
                    Movie.name, 
                    Movie.director, 
                    Movie.year, 
                    Movie.length, 
                    Movie.description, 
                    Movie.image, 
                    Movie.trailer, 
                    Movie.min_age, 
                    Movie.id_category, 
                    Category.name AS category
                FROM Movie
                JOIN Category ON Movie.id_category = Category.id
                WHERE Movie.id = :id";

        $stmt = $cnx->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Récupère le résultat sous forme d'objet
        $movieDetail = $stmt->fetch(PDO::FETCH_OBJ);

        return $movieDetail; // Retourne les détails du film
    } catch (Exception $e) {
        error_log("Erreur SQL : " . $e->getMessage()); // Log dans les erreurs PHP
        return false;
    }
}

// function getMoviesByCategory() {
//     try {
//         $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
//             PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
//         ]);

//         // Requête SQL pour récupérer les films groupés par catégorie
//         $sql = "SELECT 
//                     Category.id AS category_id, 
//                     Category.name AS category_name, 
//                     Movie.id AS movie_id, 
//                     Movie.name AS movie_name, 
//                     Movie.image AS movie_image
//                 FROM Movie
//                 JOIN Category ON Movie.id_category = Category.id
//                 ORDER BY Category.name, Movie.name";

//         $stmt = $cnx->query($sql);
//         $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

//         // Regrouper les films par catégorie
//         $categories = [];
//         foreach ($rows as $row) {
//             if (!isset($categories[$row->category_id])) {
//                 $categories[$row->category_id] = [
//                     "name" => $row->category_name,
//                     "movies" => []
//                 ];
//             }
//             $categories[$row->category_id]["movies"][] = [
//                 "id" => $row->movie_id,
//                 "name" => $row->movie_name,
//                 "image" => $row->movie_image
//             ];
//         }

//         return array_values($categories); // Retourne un tableau indexé
//     } catch (Exception $e) {
//         error_log("Erreur SQL : " . $e->getMessage());
//         return false;
//     }
// }

function getMoviesByCategory($age) {
    try {
        $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // Requête SQL pour récupérer les films groupés par catégorie
        // Si $age = 0, on ne filtre pas sur min_age
        $sql = "SELECT 
                    Category.id AS category_id, 
                    Category.name AS category_name, 
                    Movie.id AS movie_id, 
                    Movie.name AS movie_name, 
                    Movie.image AS movie_image
                FROM Movie
                JOIN Category ON Movie.id_category = Category.id
                WHERE :age = 0 OR Movie.min_age < :age
                ORDER BY Category.name, Movie.name";

        $stmt = $cnx->prepare($sql);
        $stmt->bindParam(':age', $age, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

        // Regrouper les films par catégorie
        $categories = [];
        foreach ($rows as $row) {
            if (!isset($categories[$row->category_id])) {
                $categories[$row->category_id] = [
                    "name" => $row->category_name,
                    "movies" => []
                ];
            }
            $categories[$row->category_id]["movies"][] = [
                "id" => $row->movie_id,
                "name" => $row->movie_name,
                "image" => $row->movie_image
            ];
        }

        return array_values($categories); // Retourne un tableau indexé
    } catch (Exception $e) {
        error_log("Erreur SQL : " . $e->getMessage());
        return false;
    }
}