let templateFile = await fetch("./component/featuredMovies/template.html");
let template = await templateFile.text();

let FeaturedMovies = {};

FeaturedMovies.format = function (movies) {
  if (movies.length === 0) {
    return "<p>Aucun film mis en avant pour le moment.</p>";
  }

let formattedMovies = "";
for (let movie of movies) {
    let movieHtml = template;
    movieHtml = movieHtml.replace("{{image}}", movie.image);
    movieHtml = movieHtml.replace("{{title}}", movie.name);
    movieHtml = movieHtml.replace("{{description}}", movie.description);
    formattedMovies += movieHtml;
}
return formattedMovies;
};

export { FeaturedMovies };