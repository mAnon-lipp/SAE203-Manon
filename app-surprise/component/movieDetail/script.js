import { Comment } from "../Comment/script.js";

let templateFile = await fetch("./component/movieDetail/template.html");
let template = await templateFile.text();

let MovieDetail = {};

MovieDetail.format = function (movieData) {
  let html = template;
  html = html.replace("{{movieTitle}}", movieData.name);
  html = html.replace("{{image}}", movieData.image);
  html = html.replace("{{movieSynopsis}}", movieData.description);
  html = html.replace("{{movieDirector}}", movieData.director);
  html = html.replace("{{movieYear}}", movieData.year);
  html = html.replace("{{movieCategory}}", movieData.category);
  html = html.replace("{{movieAgeRestriction}}", movieData.min_age);
  html = html.replace("{{movieTrailerUrl}}", movieData.trailer);
  html = html.replace("{{onclick}}", `C.addRating(${movieData.id})`);

  if (movieData.is_new) {
    html = html.replace("{{#is_new}}", "").replace("{{/is_new}}", '<span class="movie-tag-new">New</span>');
  } else {
    html = html.replace("{{#is_new}}", "").replace("{{/is_new}}", "");
  }

  let averageRating = movieData.average_rating || 0;
  html = html.replace("{{averageRating}}", averageRating);
  html += Comment.format(movieData.id);

  return html;
};
export { MovieDetail };