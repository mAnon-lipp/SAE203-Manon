let templateFile = await fetch("./component/film/template.html");
let template = await templateFile.text();

let templateAllFile = await fetch("./component/film/templateAll.html");
let templateAll = await templateAllFile.text();

let Movie = {};

// Formate un seul film en utilisant template.html
Movie.formatOne = function (movie, profileId, favorites) {
  let movieHtml = template;
  movieHtml = movieHtml.replace("{{titre}}", movie.name);
  movieHtml = movieHtml.replace("{{image}}", movie.image);
  movieHtml = movieHtml.replace("{{onclick}}", `C.handlerDetail(${movie.id})`);

  let isFavorite = false;

  if (Array.isArray(favorites)) {
    for (let i = 0; i < favorites.length; i++) {
      if (favorites[i].id === movie.id) {
        isFavorite = true;
        break;
      }
    }
  }

  const favoriteIcon = `
    <div class="movie-card__favorite ${isFavorite ? "active" : ""}" 
         onclick="event.stopPropagation(); C.addFavorite(${profileId}, ${movie.id}, this)">
      <svg class="heart-icon" viewBox="0 0 24 24" fill="" xmlns="http://www.w3.org/2000/svg">
        <path d="M19.5001 12.5719L12.0001 19.9999L4.50006 12.5719C4.00536 12.0905 3.6157 11.5119 3.3556 10.8726C3.09551 10.2332 2.97062 9.54688 2.98879 8.85687C3.00697 8.16685 3.16782 7.48807 3.46121 6.86327C3.75461 6.23847 4.17419 5.68119 4.69354 5.22651C5.21289 4.77184 5.82076 4.42962 6.47887 4.22141C7.13697 4.01321 7.83106 3.94352 8.51743 4.01673C9.20379 4.08995 9.86756 4.30449 10.4669 4.64684C11.0663 4.98919 11.5883 5.45193 12.0001 6.00593C12.4136 5.45595 12.9362 4.99725 13.5352 4.65854C14.1341 4.31982 14.7966 4.10838 15.481 4.03745C16.1654 3.96652 16.8571 4.03763 17.5128 4.24632C18.1685 4.45502 18.7741 4.79681 19.2916 5.2503C19.8091 5.70379 20.2275 6.25922 20.5205 6.88182C20.8135 7.50443 20.9748 8.18082 20.9944 8.86864C21.0139 9.55647 20.8913 10.2409 20.6342 10.8792C20.3771 11.5174 19.991 12.0958 19.5001 12.5779" 
              stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>`;

  movieHtml = movieHtml.replace("{{favorite}}", favoriteIcon);

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
    formattedMovies += Movie.formatOne(movies[i], profileId, favorites || []); 
  }

  let allMoviesHtml = templateAll;
  allMoviesHtml = allMoviesHtml.replace("{{movies}}", formattedMovies);
  return allMoviesHtml;
};

export { Movie };