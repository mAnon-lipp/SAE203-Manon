Itération 5 : Ajout de la table 'Profil'. 
Pour permettre l'ajout de profils utilisateurs, j'ai créé une table 'Profil' avec les colonnes suivantes : id en INT avec auto-incrémentation, name en VARCHAR(255), avatar en VARCHAR(255) et min_age en INT(11). Pour les valeurs, j'ai décidé de conserver les mêmes que celles utilisées dans les tables 'Movie' et 'Category'. Concernant les noms, j'ai choisi de les garder en anglais et tout en minuscule.

Itération 9 : Ajout de la table 'Favorites'. 
Pour permettre l'ajout d'un film aux favoris pour l'utilisateur sélectionné, j'ai créé une table 'Favorites' avec les colonnes suivantes : id en INT avec auto-incrémentation, profile_id, qui est une clé étrangère pointant vers l'id de la table 'Profil', et movie_id, qui est une clé étrangère pointant vers l'id de la table 'Movie'. Concernant les noms, j'ai choisi de les garder en anglais et tout en minuscule.

Itération 11 : Ajout de la colonne 'is_featured'. 
Pour permettre la mise en avant de certains films, j'ai ajouté une colonne is_featured à la table 'Movie'. Cette colonne est de type TINYINT(1), afin de simuler un booléen, avec une valeur par défaut définie à 0.

Itération 14 : Ajout de la table 'Ratings'. 
Pour permettre un système de notation, j'ai créé une table 'Ratings' avec les colonnes suivantes : id en INT avec auto-incrémentation, profile_id, qui est une clé étrangère pointant vers l'id de la table 'Profil', movie_id, qui est une clé étrangère pointant vers l'id de la table 'Movie', et rating en TINYINT(4), qui permet de stocker la note donnée par l'utilisateur. Concernant les noms, j'ai choisi de les garder en anglais et tout en minuscule.

Itération 15 : Ajout de la table 'Comments'. 
Pour permettre un système de commentaires, j'ai créé une table 'Comments' avec les colonnes suivantes : id en INT avec auto-incrémentation, profile_id, qui est une clé étrangère pointant vers l'id de la table 'Profil', movie_id, qui est une clé étrangère pointant vers l'id de la table 'Movie', comment en TEXTE, qui permet de stocker le commentaire envoyé, et created_at en DATETIME, afin d'enregistrer l'heure et la date auxquelles le commentaire a été posté.

Itération 16 : Ajout de la colonne "status". 
Pour permettre une modération des commentaires, j'ai créé la colonne status dans la table "Comments" avec l'énumération enum('pending', 'approved', 'deleted'), qui me permet de contrôler le statut des commentaires. J'ai défini "pending" comme valeur par défaut afin de m'assurer que les commentaires n'apparaissent pas tant qu'ils n'ont pas été modérés.