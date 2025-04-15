<?php

/** ARCHITECTURE PHP SERVEUR  : Rôle du fichier controller.php
 * 
 *  Dans ce fichier, on va définir les fonctions de contrôle qui vont traiter les requêtes HTTP.
 *  Les requêtes HTTP sont interprétées selon la valeur du paramètre 'todo' de la requête (voir script.php)
 *  Pour chaque valeur différente, on déclarera une fonction de contrôle différente.
 * 
 *  Les fonctions de contrôle vont éventuellement lire les paramètres additionnels de la requête, 
 *  les vérifier, puis appeler les fonctions du modèle (model.php) pour effectuer les opérations
 *  nécessaires sur la base de données.
 *  
 *  Si la fonction échoue à traiter la requête, elle retourne false (mauvais paramètres, erreur de connexion à la BDD, etc.)
 *  Sinon elle retourne le résultat de l'opération (des données ou un message) à includre dans la réponse HTTP.
 */

/** Inclusion du fichier model.php
 *  Pour pouvoir utiliser les fonctions qui y sont déclarées et qui permettent
 *  de faire des opérations sur les données stockées en base de données.
 */
require("model.php");

function readController(){
 
    // ON VERIFIE QUE LES PARAMETRES EXISTENT ET SONT NON VIDES
    // Vérification du paramètre 'todo' 

    // if ( isset($_REQUEST['todo'])==false || empty($_REQUEST['todo'])==true ){
    //     return false;
    // }   

    // si on arrive ici c'est que les paramètres existent et sont valides, on peut interroger la BDD
    // Appel de la fonction getMovie déclarée dans model.php pour extraire de la BDD les informations des films
    $movies = getMovie();
    return $movies;
}

function addController(){
    
    $name = $_REQUEST['name'];
    $director = $_REQUEST['director'];
    $year = $_REQUEST['year'];
    $length = $_REQUEST['length'];
    $description = $_REQUEST['description'];
    $id_category = $_REQUEST['id_category'];
    $image = $_REQUEST['image'];
    $trailer = $_REQUEST['trailer'];
    $min_age = $_REQUEST['min_age'];

    // Appel de la fonction addMovie déclarée dans model.php pour ajouter un film à la BDD
    $ok = addMovie($name, $director, $year, $length, $description,$id_category,$image, $trailer, $min_age);
   
    if ($ok!=0){
        return "$name a été ajouté avec succès";
      }
      else{
        return "Le film n'a pas pu être ajouté";
      }
}

function addProfileController(){
    if (!isset($_REQUEST['name']) || !isset($_REQUEST['min_age'])) {
        http_response_code(400); 
        echo json_encode(["error" => "Paramètres manquants pour ajouter un profil"]);
        return false;
    }

    $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
    $name = $_REQUEST['name'];
    $avatar = $_REQUEST['avatar'];
    $min_age = intval($_REQUEST['min_age']);

    $ok = addProfile($id, $name, $avatar, $min_age);

    if ($ok != 0) {
        return "$name a été ajouté ou remplacé avec succès";
    } else {
        return "Le profil n'a pas pu être ajouté ou remplacé";
    }
}


function readMovieDetailController() {

    if (!isset($_REQUEST['id'])) {
        return false; 
    }

    $id = intval($_REQUEST['id']);
    $movie = getMovieDetail($id);

    if ($movie) {
        return $movie;
    } else {
        return false;
    }
}

function getCategoriesController() {
    $categories = getCategories();
    return $categories ? $categories : [];
}

function readMoviesByCategoryController() {
    $age = isset($_REQUEST['age']) ? intval($_REQUEST['age']) : 0; 
    $categories = getMoviesByCategory($age); 
    return $categories ? $categories : [];
}

function getFeaturedMoviesController() {
    $featuredMovies = getFeaturedMovies(); 
    return $featuredMovies ? $featuredMovies : [];
}

function readProfilesController() {
    $profiles = getProfiles(); 
    return $profiles ? $profiles : false;
}

function addFavoriteController() {
    $profile_id = $_REQUEST['profile_id'];
    $movie_id = $_REQUEST['movie_id'];

    if (isFavorite($profile_id, $movie_id)) {
        return "Le film est déjà dans vos favoris.";
    }

    $ok = addFavorite($profile_id, $movie_id);
    return $ok ? "Le film a été ajouté à vos favoris." : "Erreur lors de l'ajout aux favoris.";
}

function getFavoritesController() {
    $profile_id = $_REQUEST['profile_id'];
    return getFavorites($profile_id);
}

function removeFavoriteController() {
    $profile_id = $_REQUEST['profile_id'];
    $movie_id = $_REQUEST['movie_id'];

    $ok = removeFavorite($profile_id, $movie_id);
    return $ok ? "Le film a été retiré de vos favoris." : "Erreur lors de la suppression du favori.";
}

function searchMoviesController() {
    $keyword = isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
    $category = isset($_REQUEST['category']) ? intval($_REQUEST['category']) : null;
    $year = isset($_REQUEST['year']) ? intval($_REQUEST['year']) : null;

    if (empty($keyword) && !$category && !$year) {
        return []; 
    }

    $movies = searchMovies($keyword, $category, $year);
    return $movies ? $movies : [];
}

function updateFeaturedStatusController() {
    if (!isset($_REQUEST['movie_id']) || !isset($_REQUEST['is_featured'])) {
        return false;
    }

    $movie_id = intval($_REQUEST['movie_id']);
    $is_featured = filter_var($_REQUEST['is_featured'], FILTER_VALIDATE_BOOLEAN);

    $result = updateFeaturedStatus($movie_id, $is_featured);
    return $result ? "Le statut du film a été mis à jour avec succès." : "Erreur lors de la mise à jour du statut.";
}

function addRatingController() {
    $profile_id = $_REQUEST['profile_id'];
    $movie_id = $_REQUEST['movie_id'];
    $rating = intval($_REQUEST['rating']);

    if (hasRated($profile_id, $movie_id)) {
        return "Vous avez déjà noté ce film.";
    }

    $ok = addRating($profile_id, $movie_id, $rating);
    return $ok ? "Votre note a été enregistrée." : "Erreur lors de l'enregistrement de la note.";
}

function getAverageRatingController() {
    $movie_id = $_REQUEST['movie_id'];
    return getAverageRating($movie_id);
}

function addCommentController() {
    if (!isset($_REQUEST['movie_id']) || !isset($_REQUEST['profile_id']) || !isset($_REQUEST['comment'])) {
        return false;
    }

    $movie_id = intval($_REQUEST['movie_id']);
    $profile_id = intval($_REQUEST['profile_id']);
    $comment = $_REQUEST['comment'];

    $ok = addComment($movie_id, $profile_id, $comment);
    return $ok ? "Commentaire ajouté avec succès." : "Erreur lors de l'ajout du commentaire.";
}

function getCommentsController() {
    if (!isset($_REQUEST['movie_id'])) {
        return false;
    }

    $movie_id = intval($_REQUEST['movie_id']);
    return getComments($movie_id);
}


function getPendingCommentsController() {
    $comments = getPendingComments();
    return $comments ? $comments : [];
}

function approveCommentController() {
    if (!isset($_REQUEST['comment_id'])) {
        return false;
    }
    $commentId = intval($_REQUEST['comment_id']);
    $ok = approveComment($commentId);
    return $ok ? "Le commentaire a été approuvé avec succès." : "Erreur lors de l'approbation du commentaire.";
}

function deleteCommentController() {
    if (!isset($_REQUEST['comment_id'])) {
        return false;
    }
    $commentId = intval($_REQUEST['comment_id']);
    $ok = deleteComment($commentId);
    return $ok ? "Le commentaire a été supprimé avec succès." : "Erreur lors de la suppression du commentaire.";
}