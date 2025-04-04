let templateFile = await fetch("./component/movieDetail/template.html");
let template = await templateFile.text();

let MovieDetail = {};

MovieDetail.format = function (movieData) {
  let html = template;
  html = html.replace("{{movieTitle}}", movieData.name || "Unknown Title");
  html = html.replace("{{image}}", movieData.image || "");
  html = html.replace("{{movieSynopsis}}", movieData.description || "No description available.");
  html = html.replace("{{movieDirector}}", movieData.director || "Unknown Director");
  html = html.replace("{{movieYear}}", movieData.year || "Unknown Year");
  html = html.replace("{{movieCategory}}", movieData.category || "Unknown Category");
  html = html.replace("{{movieAgeRestriction}}", movieData.min_age || "N/A");
  html = html.replace("{{movieTrailerUrl}}", movieData.trailer || "#");
  return html;
};

export { MovieDetail };
