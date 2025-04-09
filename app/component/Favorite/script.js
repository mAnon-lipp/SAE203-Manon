let templateFile = await fetch("./component/Favorite/template.html");
let template = await templateFile.text();

let Favorite = {};

Favorite.format = function (favoriteData) {
    console.log("favoriteData:", favoriteData); // Log pour inspecter les données passées
    let html = template;
    // Remplace les balises dans le template
    html = html.replace("{{image}}", favoriteData.image || "default-image.png");
    html = html.replace("{{name}}", favoriteData.name || "Nom inconnu");
    html = html.replace(/{{id}}/g, favoriteData.id); // Remplace toutes les occurrences de {{id}}
    html = html.replace("{{handler}}", `C.handlerDetail(${favoriteData.id})`); // Assurez-vous que C.handlerDetail est défini dans votre contexte
    return html;
};

export { Favorite };
