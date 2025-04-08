let templateFile = await fetch("./component/film/template.html");
let template = await templateFile.text();

let Movie = {};

Movie.format = function (movies, profileId, favorites) {

  let html = "";
  let i = 0;

  // Ensure favorites is an array
  favorites = Array.isArray(favorites) ? favorites : [];

  while (i < movies.length) {
    let movie = movies[i];
    let movieHtml = template;
    movieHtml = movieHtml.replace("{{titre}}", movie.name);
    movieHtml = movieHtml.replace("{{image}}", movie.image);
    movieHtml = movieHtml.replace("{{onclick}}", `C.handlerDetail(${movie.id})`);
    let isFavorite = false;
    for (let fav of favorites) {
      if (fav.id === movie.id) {
        isFavorite = true;
        break;
      }
    }
    const favoriteButton = isFavorite
      ? `<button disabled>Favori</button>`
      : `<button onclick="C.addFavorite(${profileId}, ${movie.id})">Ajouter aux favoris</button>`;

    movieHtml += favoriteButton;
    html += movieHtml;
    i++;
  }
  return html;
};

export { Movie };
