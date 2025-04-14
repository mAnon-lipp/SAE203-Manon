// URL où se trouve le répertoire "server" sur mmi.unilim.fr
let HOST_URL = "../server";

let DataMovie = {};

// DataMovie.requestMovies = async function () {
//   // Récupération des films
//   let answer = await fetch(HOST_URL + "server/script.php?todo=getMovie");
//   let movies = await answer.json();
//   return movies;
// };

DataMovie.requestMovies = async function () {
  let answer = await fetch(HOST_URL + "/script.php?todo=getMovie");
  let movies = await answer.json();
  return movies;
};

DataMovie.requestMovieDetails = async function (movieId) {
  let answer = await fetch(
    HOST_URL + `/script.php?todo=readMovieDetail&id=${movieId}`
  );
  let movieDetails = await answer.json();

  // Récupérer la note moyenne
  let averageRating = await fetch(
    HOST_URL + `/script.php?todo=getAverageRating&movie_id=${movieId}`
  );
  movieDetails.average_rating = await averageRating.json();

  return movieDetails;
};

DataMovie.addRating = async function (profileId, movieId, rating) {
  const url = `${HOST_URL}/script.php?todo=addRating&profile_id=${profileId}&movie_id=${movieId}&rating=${rating}`;
  let response = await fetch(url);
  let message = await response.json();
  return message; // Retourne le message de confirmation ou d'erreur
};

DataMovie.requestMoviesByCategory = async function (age) {
  const url = HOST_URL + "/script.php?todo=readMovies&age=" + age;
  console.log("URL générée :", url); // Log pour vérifier l'URL
  let answer = await fetch(url);
  let categories = await answer.json();
  console.log("Données reçues par catégorie :", categories); // Vérifiez si is_new est présent
  return categories;
};

DataMovie.requestFeaturedMovies = async function () {
  let answer = await fetch(
    HOST_URL + "/script.php?todo=getFeaturedMovies"
  );
  let featuredMovies = await answer.json();
  return featuredMovies;
};

DataMovie.addFavorite = async function (profileId, movieId) {
  const url = `${HOST_URL}/script.php?todo=addFavorite&profile_id=${profileId}&movie_id=${movieId}`;
  console.log("URL générée pour l'ajout de favori :", url);

  // Effectuer la requête fetch pour obtenir la réponse
  let answer = await fetch(url); // Correction : ajout de fetch pour récupérer la réponse
  let response = await answer.json(); // Convertir la réponse en JSON
  return response; // Retourner la réponse
};

DataMovie.getFavorites = async function (profileId) {
  let answer = await fetch(
    `${HOST_URL}/script.php?todo=getFavorites&profile_id=${profileId}`
  );
  let favorites = await answer.json();
  return favorites;
};

DataMovie.removeFavorite = async function (profileId, movieId) {
  const url = `${HOST_URL}/script.php?todo=removeFavorite&profile_id=${profileId}&movie_id=${movieId}`;
  console.log("URL générée pour la suppression de favori :", url);

  let answer = await fetch(url);
  let response = await answer.json();
  return response;
};

DataMovie.searchMovies = async function (keyword, category = null, year = null) {
  const params = new URLSearchParams();
  if (keyword) params.append("keyword", keyword);
  if (category) params.append("category", category);
  if (year) params.append("year", year);

  const response = await fetch(`/script.php?todo=searchMovies&${params.toString()}`);
  return response.json();
};

DataMovie.addComment = async function (movieId, profileId, comment) {
  const url = `${HOST_URL}/script.php?todo=addComment&movie_id=${movieId}&profile_id=${profileId}&comment=${encodeURIComponent(
    comment
  )}`;
  let response = await fetch(url);
  return await response.json();
};

DataMovie.getComments = async function (movieId) {
  const url = `${HOST_URL}/script.php?todo=getComments&movie_id=${movieId}`;
  let response = await fetch(url);
  return await response.json();
};
// On exporte la fonction DataMovie.requestMovies
export { DataMovie };
