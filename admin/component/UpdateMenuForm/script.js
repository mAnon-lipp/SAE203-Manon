let templateFile = await fetch("./component/UpdateMenuForm/template.html");
let template = await templateFile.text();

let UpdateMenuForm = {};

UpdateMenuForm.format = function (profiles, handler) {
  let html = template;

  // Génération des options pour le menu déroulant sans utiliser .map
  let options = "";
  for (let i = 0; i < profiles.length; i++) {
    const p = profiles[i];
    options += `<option value="${p.id}" data-name="${p.name}" data-avatar="${p.avatar}" data-age="${p.min_age}">${p.name}</option>`;
  }

  html = html.replace("{{options}}", options);
  html = html.replace("{{handler}}", handler);

  return html;
};

// Ajout d'un gestionnaire pour remplir automatiquement les champs
UpdateMenuForm.init = function () {
  const select = document.getElementById("profile-select");
  const nameField = document.getElementById("profile-name");
  const avatarField = document.getElementById("profile-avatar");
  const minAgeField = document.getElementById("profile-min-age");

  select.addEventListener("change", (event) => {
    const selectedOption = event.target.selectedOptions[0];
    if (selectedOption) {
      nameField.value = selectedOption.dataset.name || "";
      avatarField.value = selectedOption.dataset.avatar || "";
      minAgeField.value = selectedOption.dataset.age || "";
    }
  });
};

export { UpdateMenuForm };
