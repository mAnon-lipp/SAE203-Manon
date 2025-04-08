let templateFile = await fetch("./component/NavBar/template.html");
let template = await templateFile.text();

let NavBar = {};

NavBar.format = function (hAbout, hShowMovies, profiles) {
  let html = template;
  html = html.replace("{{hAbout}}", hAbout);
  html = html.replace("{{hShowMovies}}", hShowMovies);

  let options = `<option value="" data-img="" data-age="0">Choisir un profil</option>`; // Option par défaut
  for (let i = 0; i < profiles.length; i++) {
    let p = profiles[i];
    options += `<option value="${p.id}" data-img="${p.avatar}" data-age="${p.min_age}">${p.name}</option>`;
  }

  let image = profiles[0]?.avatar || "";

  html = html.replace("{{options}}", options);
  html = html.replace("{{image}}", image);

  return html;
};

export { NavBar };
