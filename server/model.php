<?php
/**
 * Ce fichier contient toutes les fonctions qui réalisent des opérations
 * sur la base de données, telles que les requêtes SQL pour insérer, 
 * mettre à jour, supprimer ou récupérer des données.
 */

/**
 * Définition des constantes de connexion à la base de données.
 *
 * HOST : Nom d'hôte du serveur de base de données, ici "localhost".
 * DBNAME : Nom de la base de données
 * DBLOGIN : Nom d'utilisateur pour se connecter à la base de données.
 * DBPWD : Mot de passe pour se connecter à la base de données.
 */
define("HOST", "localhost");
define("DBNAME", "lippler1");
define("DBLOGIN", "lippler1");
define("DBPWD", "lippler1");


// function getMovie(){
//     // Connexion à la base de données
//     $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
//     // Requête SQL pour récupérer le nom, l'image et l'id du film
//     $sql = "SELECT id, name, image FROM Movie";

//     // exécution de la requête SQL via la connexion à la bdd et récupération de la réponse sur serveur MySQL
//     $answer = $cnx->query($sql);
//     // conversion des lignes récupérées en tableau d'objets (chaque ligne devient un objet)
//     $res = $answer->fetchAll(PDO::FETCH_OBJ);
//     // et on renvoie le tout.
//     return $res; // Retourne les résultats
// }

function getMovie() {
    try {
        $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        $sql = "SELECT id, name, image FROM Movie";
        $answer = $cnx->query($sql);
        return $answer->fetchAll(PDO::FETCH_OBJ);
    } catch (Exception $e) {
        error_log("Erreur SQL : " . $e->getMessage()); // Log dans les erreurs PHP
        return false;
    }
}


