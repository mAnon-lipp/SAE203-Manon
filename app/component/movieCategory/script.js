import { Movie } from "../film/script.js";

let templateFile = await fetch("./component/movieCategory/template.html");
let template = await templateFile.text();

let MovieCategory = {};

MovieCategory.format = function (category, profileId) {
  let moviesHtml = Movie.format(category.movies, profileId, category.favorites);
  return template
    .replace("{{categoryName}}", category.name)
    .replace("{{moviesList}}", moviesHtml);
};

export { MovieCategory };
