// URL où se trouve le répertoire "server" sur mmi.unilim.fr
let HOST_URL = "https://mmi.unilim.fr/~lippler1/SAE203-Manon";

let DataMovie = {};

DataMovie.requestMovies = async function () {
  let answer = await fetch(HOST_URL + "/server/script.php?todo=getMovie");
  let movies = await answer.json();
  return movies;
};

/** DataMovie.add
 *
 * Prend en paramètre un objet FormData (données de formulaire) à envoyer au serveur.
 * Ces données sont incluses dans une requête HTTP en méthode POST.
 * Une requête POST au lieu de GET n'affiche pas les données dans l'URL (plus discret).
 * Les données sont placées dans le corps (body) de la requête HTTP. Elles restent visibles mais
 * en utilisant les outils de développement du navigateur (Network > Payload).
 * La requête comprend aussi un paramètre todo valant add pour indiquer au serveur qu'il
 * s'agit d'une mise à jour (car on a codé le serveur pour qu'il sache quoi faire en fonction de la valeur de todo).
 *
 * @param {*} fdata un objet FormData contenant les données du formulaire à envoyer au serveur.
 * @returns la réponse du serveur.
 */
DataMovie.addMovie = async function (fdata) {
  // fetch possède un deuxième paramètre (optionnel) qui est un objet de configuration de la requête HTTP:
  //  - method : la méthode HTTP à utiliser (GET, POST...)
  //  - body : les données à envoyer au serveur (sous forme d'objet FormData ou bien d'une chaîne de caractères, par exempe JSON)
  let config = {
    method: "POST", // méthode HTTP à utiliser
    body: fdata, // données à envoyer sous forme d'objet FormData
  };
  let answer = await fetch(HOST_URL + "/server/script.php?todo=addMovie", config);
  let data = await answer.json();
  return data;
};

DataMovie.getCategories = async function () {
  let response = await fetch(HOST_URL + "/server/script.php?todo=getCategories");
  return response.json();
};

DataMovie.searchMovies = async function (keyword, category = null, year = null) {
  const params = new URLSearchParams();
  if (keyword) params.append("keyword", keyword);
  if (category) params.append("category", category);
  if (year) params.append("year", year);

  const response = await fetch(`${HOST_URL}/server/script.php?todo=searchMovies&${params.toString()}`);
  return response.json();
};

DataMovie.updateFeaturedStatus = async function (movieId, isFeatured) {
  const url = `${HOST_URL}/server/script.php?todo=updateFeaturedStatus&movie_id=${movieId}&is_featured=${isFeatured}`;
  let answer = await fetch(url);
  let response = await answer.json();
  return response;
};

export { DataMovie };
