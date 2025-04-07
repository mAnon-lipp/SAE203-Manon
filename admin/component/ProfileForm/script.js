let templateFile = await fetch('./component/ProfileForm/template.html');
let template = await templateFile.text();


let ProfileForm = {};

ProfileForm.format = function(profiles, handler){
    let html= template;
    let options = profiles
    .map(
      (p) =>
        `<option value="${p.id}" data-name="${p.name}" data-avatar="${p.avatar}" data-age="${p.min_age}">${p.name}</option>`
    )
    .join("");

    html = html.replace("{{options}}", options);
    html = html.replace('{{handler}}', handler);
    return html;
}

ProfileForm.init = function () {
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

export {ProfileForm};
