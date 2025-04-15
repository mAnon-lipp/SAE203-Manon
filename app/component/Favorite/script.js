let templateFile = await fetch("./component/Favorite/template.html");
let template = await templateFile.text();

let Favorite = {};

Favorite.format = function (favoriteData) {
    let html = template;
    html = html.replace("{{image}}", favoriteData.image || "default-image.png");
    html = html.replace("{{name}}", favoriteData.name || "Nom inconnu");
    html = html.replace("{{id}}", favoriteData.id); 
    html = html.replace("{{handler}}", `C.handlerDetail(${favoriteData.id})`); 
    return html;
};

export { Favorite };
