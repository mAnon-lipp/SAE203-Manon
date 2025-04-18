let templateFile = await fetch("./component/featuredMovies/template.html");
let template = await templateFile.text();

let templateAllFile = await fetch("./component/featuredMovies/templateAll.html");
let templateAll = await templateAllFile.text();

let FeaturedMovies = {};

// Formate un seul film en utilisant template.html
FeaturedMovies.formatOne = function (movie) {
  let movieHtml = template;
  movieHtml = movieHtml.replace("{{image}}", movie.image);
  movieHtml = movieHtml.replace("{{title}}", movie.name);
  movieHtml = movieHtml.replace("{{description}}", movie.description);
  movieHtml = movieHtml.replace("{{onclick}}", `C.handlerDetail(${movie.id})`);
  return movieHtml;
};

FeaturedMovies.renderCarousel = function (movies) {
  let carouselContainer = document.querySelector("#featured-movies");
  carouselContainer.innerHTML = templateAll;

  let carouselItems = document.querySelector("#carousel-items");
  let carouselIndicators = document.querySelector("#carousel-indicators");

  let carouselContent = "";
  let indicatorsContent = "";

  for (let i = 0; i < movies.length; i++) {
    carouselContent += FeaturedMovies.formatOne(movies[i]);
    indicatorsContent += `<span class="carousel__indicator" data-index="${i}" onclick="C.goToSlide(${i})"></span>`;
  }

  carouselItems.innerHTML = carouselContent;
  carouselIndicators.innerHTML = indicatorsContent;

  let items = document.querySelectorAll(".carousel__item");
  let indicators = document.querySelectorAll(".carousel__indicator");

  // Masquer tous les films sauf le premier
  for (let i = 0; i < items.length; i++) {
    items[i].style.display = i === 0 ? "block" : "none";
    indicators[i].classList.toggle("active", i === 0); // Activer le premier indicateur
  }
};

export { FeaturedMovies };
