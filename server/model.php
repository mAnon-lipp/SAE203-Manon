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

    
    $favoritesSql = "SELECT movie_id FROM Favorites WHERE profile_id = :id";
    $favoritesStmt = $cnx->prepare($favoritesSql);
    $favoritesStmt->bindParam(':id', $id, PDO::PARAM_INT);
    $favoritesStmt->execute();
    $favorites = $favoritesStmt->fetchAll(PDO::FETCH_COLUMN);

   
    $ratingsSql = "SELECT movie_id, rating FROM Ratings WHERE profile_id = :id";
    $ratingsStmt = $cnx->prepare($ratingsSql);
    $ratingsStmt->bindParam(':id', $id, PDO::PARAM_INT);
    $ratingsStmt->execute();
    $ratings = $ratingsStmt->fetchAll(PDO::FETCH_ASSOC);

    
    $commentsSql = "SELECT movie_id, comment FROM Comments WHERE profile_id = :id";
    $commentsStmt = $cnx->prepare($commentsSql);
    $commentsStmt->bindParam(':id', $id, PDO::PARAM_INT);
    $commentsStmt->execute();
    $comments = $commentsStmt->fetchAll(PDO::FETCH_ASSOC);

    
    $deleteFavoritesSql = "DELETE FROM Favorites WHERE profile_id = :id";
    $deleteFavoritesStmt = $cnx->prepare($deleteFavoritesSql);
    $deleteFavoritesStmt->bindParam(':id', $id, PDO::PARAM_INT);
    $deleteFavoritesStmt->execute();

    $deleteRatingsSql = "DELETE FROM Ratings WHERE profile_id = :id";
    $deleteRatingsStmt = $cnx->prepare($deleteRatingsSql);
    $deleteRatingsStmt->bindParam(':id', $id, PDO::PARAM_INT);
    $deleteRatingsStmt->execute();

    $deleteCommentsSql = "DELETE FROM Comments WHERE profile_id = :id";
    $deleteCommentsStmt = $cnx->prepare($deleteCommentsSql);
    $deleteCommentsStmt->bindParam(':id', $id, PDO::PARAM_INT);
    $deleteCommentsStmt->execute();

    
    $sql = "REPLACE INTO Profil (id, name, avatar, min_age) 
            VALUES (:id, :name, :avatar, :min_age)";
    $stmt = $cnx->prepare($sql);

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':avatar', $avatar, PDO::PARAM_STR);
    $stmt->bindParam(':min_age', $min_age, PDO::PARAM_INT);

    $stmt->execute();

    
    $insertFavoriteSql = "INSERT INTO Favorites (profile_id, movie_id) VALUES (:profile_id, :movie_id)";
    $insertFavoriteStmt = $cnx->prepare($insertFavoriteSql);

    foreach ($favorites as $movie_id) {
        $insertFavoriteStmt->bindParam(':profile_id', $id, PDO::PARAM_INT);
        $insertFavoriteStmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
        $insertFavoriteStmt->execute();
    }

    
    $insertRatingSql = "INSERT INTO Ratings (profile_id, movie_id, rating) VALUES (:profile_id, :movie_id, :rating)";
    $insertRatingStmt = $cnx->prepare($insertRatingSql);

    foreach ($ratings as $rating) {
        $insertRatingStmt->bindParam(':profile_id', $id, PDO::PARAM_INT);
        $insertRatingStmt->bindParam(':movie_id', $rating['movie_id'], PDO::PARAM_INT);
        $insertRatingStmt->bindParam(':rating', $rating['rating'], PDO::PARAM_INT);
        $insertRatingStmt->execute();
    }

    
    $insertCommentSql = "INSERT INTO Comments (profile_id, movie_id, comment) VALUES (:profile_id, :movie_id, :comment)";
    $insertCommentStmt = $cnx->prepare($insertCommentSql);

    foreach ($comments as $comment) {
        $insertCommentStmt->bindParam(':profile_id', $id, PDO::PARAM_INT);
        $insertCommentStmt->bindParam(':movie_id', $comment['movie_id'], PDO::PARAM_INT);
        $insertCommentStmt->bindParam(':comment', $comment['comment'], PDO::PARAM_STR);
        $insertCommentStmt->execute();
    }

    return $stmt->rowCount();
}

function getProfiles() {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT id, name, avatar, min_age FROM Profil";
    $stmt = $cnx->query($sql);
    return $stmt->fetchAll(PDO::FETCH_OBJ); 
}

function getMovieDetail($id) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
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
                Category.name AS category,
                (Movie.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)) AS is_new
            FROM Movie
            JOIN Category ON Movie.id_category = Category.id
            WHERE Movie.id = :id";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
}

function getCategories() {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT id, name FROM Category";
    $stmt = $cnx->query($sql);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}


function getMoviesByCategory($age) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $sql = "SELECT 
                Category.id AS category_id, 
                Category.name AS category_name, 
                Movie.id AS movie_id, 
                Movie.name AS movie_name, 
                Movie.image AS movie_image,
                (Movie.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)) AS is_new
            FROM Movie
            JOIN Category ON Movie.id_category = Category.id
            WHERE :age = 0 OR Movie.min_age <= :age
            ORDER BY Category.name, Movie.name";

    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':age', $age, PDO::PARAM_INT);
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

    if (empty($rows)) {
        return [];
    }

    
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
            "image" => $row->movie_image,
            "is_new" => (bool)$row->is_new 
        ];
    }

    return array_values($categories); 
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
    
    $sql = "SELECT 
                Movie.id, 
                Movie.name, 
                Movie.image, 
                Movie.is_featured, 
                Category.name AS category 
            FROM Movie
            LEFT JOIN Category ON Movie.id_category = Category.id
            WHERE 1=1";
    
    if (!empty($keyword)) {
        $sql .= " AND (Movie.name LIKE :keyword OR Category.name LIKE :keyword)";
    }
    if (!empty($year)) {
        $sql .= " AND Movie.year = :year";
    }

    $stmt = $cnx->prepare($sql);

    if (!empty($keyword)) {
        $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
    }
    if (!empty($year)) {
        $stmt->bindValue(':year', $year, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}


function updateFeaturedStatus($movie_id, $is_featured) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "UPDATE Movie SET is_featured = :is_featured WHERE id = :movie_id";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':is_featured', $is_featured, PDO::PARAM_BOOL);
    $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->rowCount();
}

function addRating($profile_id, $movie_id, $rating) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "INSERT INTO Ratings (profile_id, movie_id, rating) VALUES (:profile_id, :movie_id, :rating)";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':profile_id', $profile_id, PDO::PARAM_INT);
    $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
    $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->rowCount() > 0;
}

function getAverageRating($movie_id) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT AVG(rating) AS average_rating FROM Ratings WHERE movie_id = :movie_id";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
    $stmt->execute();
    $average = $stmt->fetch(PDO::FETCH_OBJ)->average_rating ?? 0;
    return round($average, 1); 
}

function hasRated($profile_id, $movie_id) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT COUNT(*) FROM Ratings WHERE profile_id = :profile_id AND movie_id = :movie_id";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':profile_id', $profile_id, PDO::PARAM_INT);
    $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

function addComment($movie_id, $profile_id, $comment) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "INSERT INTO Comments (movie_id, profile_id, comment) VALUES (:movie_id, :profile_id, :comment)";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
    $stmt->bindParam(':profile_id', $profile_id, PDO::PARAM_INT);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    return $stmt->execute();
}

function getComments($movie_id) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT Comments.comment, Comments.created_at, Profil.name AS profile_name 
            FROM Comments 
            JOIN Profil ON Comments.profile_id = Profil.id 
            WHERE Comments.movie_id = :movie_id AND Comments.status = 'approved'
            ORDER BY Comments.created_at DESC";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getPendingComments() {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT Comments.id, Comments.comment, Comments.created_at, Profil.name AS profile_name 
            FROM Comments 
            JOIN Profil ON Comments.profile_id = Profil.id 
            WHERE Comments.status = 'pending'
            ORDER BY Comments.created_at DESC";
    $stmt = $cnx->query($sql);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function approveComment($commentId) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "UPDATE Comments SET status = 'approved' WHERE id = :commentId";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':commentId', $commentId, PDO::PARAM_INT);
    return $stmt->execute();
}

function deleteComment($commentId) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "UPDATE Comments SET status = 'deleted' WHERE id = :commentId";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':commentId', $commentId, PDO::PARAM_INT);
    return $stmt->execute();
}

?>