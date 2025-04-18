import { Movie } from "../film/script.js";

let templateFile = await fetch("./component/movieCategory/template.html");
let template = await templateFile.text();

let MovieCategory = {};

MovieCategory.format = function (category, profileId) {
  let moviesHtml = Movie.format(category.movies, profileId, category.favorites);

  // Génération des indicateurs pour chaque film
  let indicatorsHtml = "";
  for (let i = 0; i < category.movies.length; i++) {
    indicatorsHtml += `<span class="category__indicator" data-index="${i}" onclick="C.goToCategorySlide('${category.name}', ${i})"></span>`;
  }

  return template
    .replace(
      '<div class="category-container"',
      `<div class="category-container" data-category="${category.name}"`
    )
    .replace("{{categoryName}}", category.name)
    .replace("{{moviesList}}", moviesHtml)
    .replace("{{indicators}}", indicatorsHtml);
};
export { MovieCategory };
