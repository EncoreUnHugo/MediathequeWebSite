
Concernant la partie JDBC ainsi que les fonctions, procédures stockées et triggers, j'ai créé 12 procédures,
3 fonction et 16 triggers côté base de données :

Procédures :

	- albumEmprunte() -> affiche l'album le plus emprunté de la médiathèque

	- livreEmprunte() -> affiche le livre le plus emprunté de la médiathèque

	- filmEmprunte() -> affiche le film le plus emprunté de la médiathèque

	- emprunteurPopA() -> affiche le plus gros emprunteur d'albums de la médiathèque

	- emprunteurPopF() -> affiche le plus gros emprunteur de films de la médiathèque

	- emprunteurPopL() -> affiche le plus gros emprunteur de livres de la médiathèque

	- empruntsAlbumsAct(identifiant) -> affiche les emprunts d'albums en cours (non rendus) de l'emprunteur dont l'identifiant est passé en paramètre

	- empruntsLivresAct(identifiant) -> affiche les emprunts de livres en cours (non rendus) de l'emprunteur dont l'identifiant est passé en paramètre

	- empruntsFilmsAct(identifiant) -> affiche les emprunts de films en cours (non rendus) de l'emprunteur dont l'identifiant est passé en paramètre

	- historiqueEmpruntF(identifiant) -> affiche l'historique de tous les emprunts de films effectués par un emprunteur dont l'identifiant est passé en paramètre

	- historiqueEmpruntL(identifiant) -> affiche l'historique de tous les emprunts de livres effectués par un emprunteur dont l'identifiant est passé en paramètre

 	- historiqueEmpruntA(identifiant) -> affiche l'historique de tous les emprunts d'albums effectués par un emprunteur dont l'identifiant est passé en paramètre

Fonctions :

	- nbExEmpruntableA(numAlbum) -> retourne le nombre d'exemplaires disponibles à l'emprunt de l'album dont le numéro est passé en paramètre

	- nbExEmpruntableF(numFilm) -> retourne le nombre d'exemplaires disponibles à l'emprunt du film dont le numéro est passé en paramètre

	- nbExEmpruntableL(numLivre) -> retourne le nombre d'exemplaires disponibles à l'emprunt du livre dont le numéro est passé en paramètre

	- grosEmpAlbInsert() -> retourne le plus gros emprunteur d'albums (ne sert qu'à être appelé par un trigger pour ajouter la stat à la table Statistiques pour contourner le problème d'accès aux callableStatement)

	- grosEmpFilmInsert() -> retourne le plus gros emprunteur de films (ne sert qu'à être appelé par un trigger pour ajouter la stat à la table Statistiques pour contourner le problème d'accès aux callableStatement)

	- grosEmpLivInsert() -> retourne le plus gros emprunteur de livres (ne sert qu'à être appelé par un trigger pour ajouter la stat à la table Statistiques pour contourner le problème d'accès aux callableStatement)
	
	- livreEmprunteInsert() -> retourne le livre le plus emprunté (ne sert qu'à être appelé par un trigger pour ajouter la stat à la table Statistiques pour contourner le problème d'accès aux callableStatement)
	
	- albumEmprunteInsert() -> retourne l'album le plus emprunté (ne sert qu'à être appelé par un trigger pour ajouter la stat à la table Statistiques pour contourner le problème d'accès aux callableStatement)

	- filmEmprunteInsert() -> retourne le film le plus emprunté (ne sert qu'à être appelé par un trigger pour ajouter la stat à la table Statistiques pour contourner le problème d'accès aux callableStatement)

Triggers : 

	- creerRetourAlbum -> crée une ligne dans la table RetourAlbum avec comme date de rendu "NULL" pour chaque nouvel emprunt d'album effectué (utile pour voir si un emprunt est en cours ou fini)

	- creerRetourFilm -> crée une ligne dans la table RetourFilm avec comme date de rendu "NULL" pour chaque nouvel emprunt de film effectué (utile pour voir si un emprunt est en cours ou fini)

	- creerRetourLivre -> crée une ligne dans la table RetourLivre avec comme date de rendu "NULL" pour chaque nouvel emprunt de livre effectué (utile pour voir si un emprunt est en cours ou fini)

	- *tous les triggers qui mettent la date du jour lors de l'ajout d'un document, d'un retour ou d'un emprunt* (10 triggers)
	
	- majTempsEmprunt -> met à jour le temps d'emprunt autorisé d'un emprunteur en fonction des modifications effectuées sur sa carte (ajout de points, retrait de points)

	- tempsCategorie -> met le temps d'emprunt autorisé correspondant à la catégorie de l'emprunteur lors de son ajout dans la base

	- declencher -> ajoute la bonne statistique à la table Statistiques en fonction de la valeur de l'id modifié dans la table Déclencheur (créé pour palier au problème d'accès aux Callable Statement en JDBC)
	

Certaines requêtes ont été faites directement en JDBC via des PreparedStatement et ResultSet.

Il y a donc au total 13 statistiques différentes consultables dans le programme :

	1 - Afficher tous les emprunts en cours d'un emprunteur donné (livres, albums et films)

	2 - Afficher l'album le plus emprunté de la médiathèque

 	3 - Afficher le livre le plus emprunté de la médiathèque

 	4 - Afficher le film le plus emprunté de la médiathèque

 	5 - Afficher l'element le plus emprunté de la médiathèque

 	6 - Afficher l'historique d'emprunt d'un emprunteur donné

 	7 - Afficher le plus gros emprunteur global de la médiatheque

 	8 - Afficher le plus gros emprunteur de livres de la médiatheque

 	9 - Afficher le plus gros emprunteur de films de la médiatheque

 	10 - Afficher le plus gros emprunteur d'albums de la médiatheque

 	11 - Afficher le nombre d'exemplaires empruntables d'un livre donné

 	12 - Afficher le nombre d'exemplaires empruntables d'un film donné

 	13 - Afficher le nombre d'exemplaires empruntables d'un album donné

Il y a aussi tout le système de suppression de données de la base de données.
Pour cela, il n'est possible que de supprimer l'intégralité des données de la base car la suppression d'une table particulière choisie
dépend de si d'autres tables ont besoin de cette table et cela était trop compliqué à gérer.

Le systeme d'insertion de données lui ne permet que d'insérer les données d'un fichier .xls bien précis qui respectent les normes de notre base
c'est à dire dont l'ordre des feuilles correspond à celui défini pour insérer les tables dans le bon ordre.
De même que pour la suppression, l'insertion de données ne permet pas l'ajout d'une table en particulier pour les même raisons de clés étrangères
qui nécessitent l'existence de certaines tables pour exister.

Il est également possible d'afficher table par tables (on choisit la table à afficher) les données du document .xls avant (ou après) leur insertion dans la base
directement dans la console d'eclipse pour vérifier que les données sont bien présentes et que le fichier est lu correctement.

Toutes ces fonctionnalités requierent des External Jars dont le driver mySql ainsi que certaines bibliothèques non présentes dans l'environnement
de base. Normalement, il n'y a pas a toucher à quoi que ce soit, les External Jars sont censé avoir un chemin relatif et vous n'aurez pas à les ajouter 
manuellement via les propriété du projet. Sinon, vous pourrez les trouvez dans les dossiers "Driver" et "BibliothequesJava".

Tout le JDBC et la création des procédures et fonctions SQL ont été réalisé par Milan Junges.
Le fichier .xls a été rempli par Milan Junges et Hugo Leroux.