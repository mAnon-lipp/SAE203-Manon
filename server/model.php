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
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT id, name, image FROM Movie";
    $answer = $cnx->query($sql);
    return $answer->fetchAll(PDO::FETCH_OBJ);
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

function addProfile($id, $name, $avatar, $min_age) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);

    try {
        // Sauvegarder les favoris existants
        $favoritesSql = "SELECT movie_id FROM Favorites WHERE profile_id = :id";
        $favoritesStmt = $cnx->prepare($favoritesSql);
        $favoritesStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $favoritesStmt->execute();
        $favorites = $favoritesStmt->fetchAll(PDO::FETCH_COLUMN);

        // Supprimer les entrées liées dans Favorites
        $deleteSql = "DELETE FROM Favorites WHERE profile_id = :id";
        $deleteStmt = $cnx->prepare($deleteSql);
        $deleteStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $deleteStmt->execute();

        // Remplacer ou insérer le profil
        $sql = "REPLACE INTO Profil (id, name, avatar, min_age) 
                VALUES (:id, :name, :avatar, :min_age)";
        $stmt = $cnx->prepare($sql);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':avatar', $avatar, PDO::PARAM_STR);
        $stmt->bindParam(':min_age', $min_age, PDO::PARAM_INT);

        $stmt->execute();

        // Réinsérer les favoris sauvegardés
        $insertFavoriteSql = "INSERT INTO Favorites (profile_id, movie_id) VALUES (:profile_id, :movie_id)";
        $insertFavoriteStmt = $cnx->prepare($insertFavoriteSql);

        $i = 0;
        $favoritesCount = count($favorites);
        while ($i < $favoritesCount) {
            $insertFavoriteStmt->bindParam(':profile_id', $id, PDO::PARAM_INT);
            $insertFavoriteStmt->bindParam(':movie_id', $favorites[$i], PDO::PARAM_INT);
            $insertFavoriteStmt->execute();
            $i++;
        }

        return $stmt->rowCount();
    } catch (Exception $e) {
        error_log("Erreur SQL : " . $e->getMessage());
        return false;
    }
}

function getProfiles() {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT id, name, avatar, min_age FROM Profil";
    $stmt = $cnx->query($sql);
    return $stmt->fetchAll(PDO::FETCH_OBJ); // Retourne les profils sous forme d'objets
}

function getMovieDetail($id) {
    // Connexion à la base de données
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);

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
}

// function getMoviesByCategory() {
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
//     }
// }


function getMoviesByCategory($age) {
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

    if (empty($rows)) {
        return [];
    }

    // Regrouper les films par catégorie sans forEach ou .map
    $categories = [];
    $i = 0;
    $rowsCount = count($rows);
    while ($i < $rowsCount) {
        $row = $rows[$i];
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
        $i++;
    }

    return array_values($categories); // Retourne un tableau indexé
}

function getFeaturedMovies() {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT id, name, image, description FROM Movie WHERE is_featured = TRUE";
    $stmt = $cnx->query($sql);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function addFavorite($profile_id, $movie_id) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "INSERT INTO Favorites (profile_id, movie_id) VALUES (:profile_id, :movie_id)";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':profile_id', $profile_id, PDO::PARAM_INT);
    $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->rowCount();
}

function getFavorites($profile_id) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT Movie.id, Movie.name, Movie.image 
            FROM Favorites 
            JOIN Movie ON Favorites.movie_id = Movie.id 
            WHERE Favorites.profile_id = :profile_id";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':profile_id', $profile_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function isFavorite($profile_id, $movie_id) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT COUNT(*) FROM Favorites WHERE profile_id = :profile_id AND movie_id = :movie_id";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':profile_id', $profile_id, PDO::PARAM_INT);
    $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

function removeFavorite($profile_id, $movie_id) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "DELETE FROM Favorites WHERE profile_id = :profile_id AND movie_id = :movie_id";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':profile_id', $profile_id, PDO::PARAM_INT);
    $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->rowCount();
}

function searchMovies($keyword, $category = null, $year = null) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    
    $sql = "SELECT id, name, image FROM Movie WHERE name LIKE :keyword";
    
    // Ajout de filtres optionnels
    if ($category) {
        $sql .= " AND id_category = :category";
    }
    if ($year) {
        $sql .= " AND year = :year";
    }

    $stmt = $cnx->prepare($sql);
    $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);

    if ($category) {
        $stmt->bindValue(':category', $category, PDO::PARAM_INT);
    }
    if ($year) {
        $stmt->bindValue(':year', $year, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

?>