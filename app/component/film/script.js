let templateFile = await fetch("./component/film/template.html");
let template = await templateFile.text();

let templateAllFile = await fetch("./component/film/templateAll.html");
let templateAll = await templateAllFile.text();

let Movie = {};

// Formate un seul film en utilisant template.html
Movie.formatOne = function (movie, profileId, favorites) {
  console.log("Film :", movie.name, "is_new :", movie.is_new);
  console.log("Profil sélectionné :", profileId);

  let movieHtml = template;
  movieHtml = movieHtml.replace("{{titre}}", movie.name);
  movieHtml = movieHtml.replace("{{image}}", movie.image);
  movieHtml = movieHtml.replace("{{onclick}}", `C.handlerDetail(${movie.id})`);

  let favoriteButton = "";

  // Vérifiez si un profil est sélectionné
  if (profileId) {
    let isFavorite = false;

    // Vérifiez si favorites est défini et est un tableau
    if (Array.isArray(favorites)) {
      for (let i = 0; i < favorites.length; i++) {
        if (favorites[i].id === movie.id) {
          isFavorite = true;
          break;
        }
      }
    }

    favoriteButton = isFavorite
      ? `<button disabled>Favori</button>` // Désactive le bouton si le film est déjà dans les favoris
      : `<button onclick="C.addFavorite(${profileId}, ${movie.id})">Ajouter aux favoris</button>`;
  }

  // Si aucun profil n'est sélectionné, ne remplacez pas {{button}} par un bouton
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
    formattedMovies += Movie.formatOne(movies[i], profileId, favorites || []); // Passe un tableau vide si favorites est undefined
  }

  let allMoviesHtml = templateAll;
  allMoviesHtml = allMoviesHtml.replace("{{movies}}", formattedMovies);
  return allMoviesHtml;
};

export { Movie };