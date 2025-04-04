// URL où se trouve le répertoire "server" sur mmi.unilim.fr
let HOST_URL = "https://mmi.unilim.fr/~lippler1/SAE203-Manon";

let DataMovie = {};

// DataMovie.requestMovies = async function () {
//   // Récupération des films
//   let answer = await fetch(HOST_URL + "server/script.php?todo=getMovie");
//   let movies = await answer.json();
//   return movies;
// };

DataMovie.requestMovies = async function () {
  let answer = await fetch(HOST_URL + "/server/script.php?todo=getMovie");
  let movies = await answer.json();
  return movies;
};

DataMovie.requestMovieDetails = async function (movieId) {
  
    let answer = await fetch(HOST_URL + `/server/script.php?todo=readMovieDetail&id=${movieId}` );
    let movieDetails = await answer.json();
    return movieDetails;
  
};
// On exporte la fonction DataMovie.requestMovies
export { DataMovie };
