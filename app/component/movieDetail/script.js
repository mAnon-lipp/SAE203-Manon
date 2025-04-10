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

  // Récupérer la note moyenne
  let averageRating = movieData.average_rating || 0;
  html = html.replace("{{averageRating}}", averageRating);
  html += Comment.format(movieData.id); // Passe l'ID du film à Comment.format

  return html;
};

MovieDetail.loadComments = function (movieId) {
  Comment.loadComments(movieId);
};

MovieDetail.addComment = function (movieId) {
  Comment.addComment(movieId);
};

export { MovieDetail };
