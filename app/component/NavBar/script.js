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



export { NavBar };

