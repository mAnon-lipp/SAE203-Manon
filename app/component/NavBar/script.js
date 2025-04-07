let templateFile = await fetch("./component/NavBar/template.html");
let template = await templateFile.text();

let NavBar = {};


NavBar.format = function (hAbout, hShowMovies, profiles) {
  let html = template;
  html = html.replace("{{hAbout}}", hAbout);
  html = html.replace("{{hShowMovies}}", hShowMovies);

  let options = profiles
    .map(
      (p) =>
        `<option value="${p.id}" data-img="${p.avatar}">${p.name}</option>`
    )
    .join("");

  let image = profiles[0]?.avatar|| "";

  html = html.replace("{{options}}", options);
  html = html.replace("{{image}}", image);

  return html;
};

document.addEventListener("DOMContentLoaded", () => {
  // Sélectionne les éléments nécessaires avec querySelector
  const profileSelect = document.querySelector("#profile-select");
  const profileImage = document.querySelector("#profile-image");
  const defaultImage = "./images/default-avatar.png"; // Chemin de l'image par défaut

  if (profileSelect && profileImage) {
    profileSelect.addEventListener("change", () => {
      // Récupère l'option sélectionnée
      const selectedOption = profileSelect.options[profileSelect.selectedIndex];
      const newImage = selectedOption.dataset.img; // Utilisation de dataset pour accéder à data-img

      // Si newImage est vide ou null, utiliser l'image par défaut
      profileImage.src = newImage || defaultImage;
    });
  }
});

export { NavBar };

