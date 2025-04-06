let navBarTemplateFile = await fetch("./component/NavBar/template.html");
let navBarTemplate = await navBarTemplateFile.text();

let profileOptionTemplateFile = await fetch("./component/NavBar/profileOptionTemplate.html");
let profileOptionTemplate = await profileOptionTemplateFile.text();

let selectedProfileTemplateFile = await fetch("./component/NavBar/selectedProfileTemplate.html");
let selectedProfileTemplate = await selectedProfileTemplateFile.text();

let NavBar = {};

NavBar.format = function (hAbout, hShowMovies, profiles) {
  let html = navBarTemplate;
  html = html.replace("{{hAbout}}", hAbout);
  html = html.replace("{{hShowMovies}}", hShowMovies);

  // Générer les options pour les profils
  let profileOptions = profiles
    .map(profile => {
      let option = profileOptionTemplate;
      option = option.replace("{{id}}", profile.id);
      option = option.replace("{{avatar}}", profile.avatar);
      option = option.replace("{{name}}", profile.name);
      return option;
    })
    .join("");

  // Générer le profil sélectionné (par défaut, le premier profil)
  let selectedProfile = selectedProfileTemplate;
  selectedProfile = selectedProfile.replace("{{avatar}}", profiles[0].avatar);
  selectedProfile = selectedProfile.replace("{{name}}", profiles[0].name);

  html = html.replace("{{selectedProfile}}", selectedProfile);
  html = html.replace("{{profileOptions}}", profileOptions);

  return html;
};

export { NavBar };
