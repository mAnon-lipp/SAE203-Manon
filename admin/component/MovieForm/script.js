import {DataMovie} from '../../data/dataMovie.js';

let templateFile = await fetch('./component/MovieForm/template.html');
let template = await templateFile.text();

let MovieForm = {};

MovieForm.format = function(handler){
    let html = template;
    html = html.replace('{{handler}}', handler);
    return html;
}

MovieForm.loadCategories = async function () {
    let categories = await DataMovie.getCategories();
    let select = document.querySelector(".addMovie__form-select");
    let optionsHTML = "";
    for (let i = 0; i < categories.length; i++) {
        optionsHTML += `<option value="${categories[i].id}">${categories[i].name}</option>`;
    }
    select.innerHTML = optionsHTML;
};

export {MovieForm};
