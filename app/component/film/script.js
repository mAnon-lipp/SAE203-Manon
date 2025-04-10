let templateFile = await fetch("./component/film/template.html");
let template = await templateFile.text();

let templateAllFile = await fetch("./component/film/templateAll.html");
let templateAll = await templateAllFile.text();

let Movie = {};

// Formate un seul film en utilisant template.html
Movie.formatOne = function (movie, profileId, favorites) {
  console.log("Film :", movie.name, "is_new :", movie.is_new); // Vérifiez la valeur de is_new

  let movieHtml = template;
  movieHtml = movieHtml.replace("{{titre}}", movie.name);
  movieHtml = movieHtml.replace("{{image}}", movie.image);
  movieHtml = movieHtml.replace("{{onclick}}", `C.handlerDetail(${movie.id})`);

  const favoriteButton = favorites?.some(fav => fav.id === movie.id)
    ? `<button disabled>Favori</button>`
    : `<button onclick="C.addFavorite(${profileId}, ${movie.id})">Ajouter aux favoris</button>`;

  movieHtml = movieHtml.replace("{{button}}", favoriteButton);

  // Ajouter ou supprimer le tag "new"
  if (movie.is_new) {
    movieHtml = movieHtml.replace("{{#is_new}}", "").replace("{{/is_new}}", '<span class="tag-new">New</span>');
  } else {
    movieHtml = movieHtml.replace("{{#is_new}}", "").replace("{{/is_new}}", "");
  }

  return movieHtml;
};
// Formate une liste de films en utilisant templateAll.html
Movie.format = function (movies, profileId, favorites) {
  if (!movies || movies.length === 0) {
    return "<p>Aucun film disponible pour le moment.</p>";
  }

  let formattedMovies = "";
  for (let i = 0; i < movies.length; i++) {
    formattedMovies += Movie.formatOne(movies[i], profileId, favorites);
  }

  let allMoviesHtml = templateAll;
  allMoviesHtml = allMoviesHtml.replace("{{movies}}", formattedMovies);
  return allMoviesHtml;
};

export { Movie };