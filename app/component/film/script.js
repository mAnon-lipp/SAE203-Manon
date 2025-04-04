let templateFile = await fetch("./component/film/template.html");
let template = await templateFile.text();

let Movie = {};

Movie.format = function (movies) {
  if (movies.length === 0) {
    return "<p>Aucun film disponible pour le moment.</p>";
  }

  let html = "";
  movies.forEach((movie) => {
    let movieHtml = template;
    movieHtml = movieHtml.replace("{{titre}}", movie.name);
    movieHtml = movieHtml.replace("{{image}}", movie.image);
    movieHtml = movieHtml.replace("{{onclick}}", `C.handlerDetail(${movie.id})`);
    html += movieHtml;
  });
  return html;
};

export { Movie };
