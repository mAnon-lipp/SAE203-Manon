let templateFile = await fetch("./component/featuredMovies/template.html");
let template = await templateFile.text();

let templateAllFile = await fetch("./component/featuredMovies/templateAll.html");
let templateAll = await templateAllFile.text();

let FeaturedMovies = {};

// Formate un seul film en utilisant template.html
FeaturedMovies.formatOne = function (movie) {
  let movieHtml = template;
  movieHtml = movieHtml.replace("{{image}}", movie.image);
  movieHtml = movieHtml.replace("{{title}}", movie.name);
  movieHtml = movieHtml.replace("{{description}}", movie.description);
  movieHtml = movieHtml.replace("{{onclick}}", `C.handlerDetail(${movie.id})`);
  return movieHtml;
};

// Formate une liste de films en utilisant templateAll.html
FeaturedMovies.format = function (movies) {
  if (movies.length === 0) {
    return "<p>Aucun film mis en avant pour le moment.</p>";
  }

  let formattedMovies = "";
  for (let movie of movies) {
    formattedMovies += FeaturedMovies.formatOne(movie);
  }

  let allMoviesHtml = templateAll;
  allMoviesHtml = allMoviesHtml.replace("{{movies}}", formattedMovies);
  return allMoviesHtml;
};

export { FeaturedMovies };