let templateFile = await fetch("./component/Favorite/template.html");
let template = await templateFile.text();

let templateAllFile = await fetch("./component/Favorite/templateAll.html");
let templateAll = await templateAllFile.text();

let Favorite = {};

// Formate un seul favori
Favorite.format = function (favoriteData) {
  let html = template;
  html = html.replace("{{image}}", favoriteData.image || "default-image.png");
  html = html.replace("{{name}}", favoriteData.name || "Nom inconnu");
  html = html.replace("{{id}}", favoriteData.id);
  html = html.replace("{{handler}}", `C.handlerDetail(${favoriteData.id})`);
  html = html.replace("{{onclick}}", `event.stopPropagation(); C.removeFavorite(C.getSelectedProfileId(), '${favoriteData.id}')`);
  return html;
};

// Formate une liste de favoris
Favorite.formatAll = function (favorites) {
  if (!favorites || favorites.length === 0) {
    // Retourne un message HTML si la liste est vide
    return "<p class='no-favorites'>Votre liste de favoris est vide.</p>";
  }

  let formattedFavorites = "";
  for (let i = 0; i < favorites.length; i++) {
    formattedFavorites += Favorite.format(favorites[i]);
  }

  let allFavoritesHtml = templateAll;
  allFavoritesHtml = allFavoritesHtml.replace("{{movies}}", formattedFavorites);
  return allFavoritesHtml;
};
export { Favorite };