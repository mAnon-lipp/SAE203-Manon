let HOST_URL = "../server";

let DataProfile = {};



DataProfile.addProfile = async function (fdata) {
  // fetch possède un deuxième paramètre (optionnel) qui est un objet de configuration de la requête HTTP:
  //  - method : la méthode HTTP à utiliser (GET, POST...)
  //  - body : les données à envoyer au serveur (sous forme d'objet FormData ou bien d'une chaîne de caractères, par exempe JSON)

  let config = {
    method: "POST", // méthode HTTP à utiliser
    body: fdata, // données à envoyer sous forme d'objet FormData
  };
  let answer = await fetch(HOST_URL + "/script.php?todo=addProfile", config);
  let data = await answer.json();
  return data;
};


/** DataProfile.update
 *
 * Prend en paramètre un objet FormData (données de formulaire) à envoyer au serveur.
 * Ces données sont incluses dans une requête HTTP en méthode POST.
 * Une requête POST au lieu de GET n'affiche pas les données dans l'URL (plus discret).
 * Les données sont placées dans le corps (body) de la requête HTTP. Elles restent visibles mais
 * en utilisant les outils de développement du navigateur (Network > Payload).
 * La requête comprend aussi un paramètre todo valant updateProfile pour indiquer au serveur qu'il
 * s'agit d'une mise à jour (car on a codé le serveur pour qu'il sache quoi faire en fonction de la valeur de todo).
 *
 * @param {*} fdata un objet FormData contenant les données du formulaire à envoyer au serveur.
 * @returns la réponse du serveur.
 */
DataProfile.updateProfile = async function (fdata) {
  // Configuration de la requête HTTP
  let config = {
    method: "POST", // méthode HTTP POST pour envoyer les données
    body: fdata, // données à envoyer sous forme d'objet FormData
  };

  // Envoi de la requête au serveur avec le paramètre `todo=updateProfile`
  let answer = await fetch(HOST_URL + "/script.php?todo=updateProfile", config);
  let data = await answer.json(); // Conversion de la réponse en JSON
  return data; // Retourne la réponse du serveur
};


/** DataProfile.getProfiles
 *
 * Récupère la liste des profils depuis le serveur.
 * @returns {Array} Une liste de profils.
 */
DataProfile.getProfiles = async function () {
  let answer = await fetch(HOST_URL + "/script.php?todo=readProfiles");
  let data = await answer.json();
  return data;
};

export { DataProfile };