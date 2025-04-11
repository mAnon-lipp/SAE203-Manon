
let MovieSearch = {};

MovieSearch.init = function () {
  // Initialise le composant en ajoutant les gestionnaires d'événements si nécessaire
  document.querySelector("#searchKeyword").addEventListener("keypress", (e) => {
    if (e.key === "Enter") {
      C.handlerSearchMovies();
    }
  });
};

MovieSearch.formatResults = function (movies, updateHandler) {
  if (movies.length === 0) {
    return `<p>Aucun film ne correspond à votre recherche.</p>`;
  }

  let html = "";
  movies.forEach((movie) => {
    html += `
      <div class="movieSearch__card">
        <h3>${movie.name}</h3>
        <p>Catégorie : ${movie.category || "Non spécifiée"}</p>
        <p>Mis en avant : ${movie.is_featured ? "Oui" : "Non"}</p>
        <button type="button" onclick="(${updateHandler})(${movie.id}, ${!movie.is_featured})">
          ${movie.is_featured ? "Retirer" : "Mettre en avant"}
        </button>
      </div>
    `;
  });

  return html;
};

export { MovieSearch };