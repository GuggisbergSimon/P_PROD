# Application Cafetaria
Projet en cours de progrès pour permettre la réservation de menus, et de table, à terme, à la cafétaria de l'ETML. Plus d'informations via la documentation se trouvant dans le K/INF/...

Le projet était d'abord de permettre aux végétariens de pouvoir s'inscrire à la cafétaria, puis au reste des client, en spécifiant notamment, le numéro de la table souhaitée, le menu, l'heure, le jour et enfin le nom de la personne.
Nous avons ajouté la possiblité d'avoir plusieurs plats, et également de choisir la table à laquelle on souhaite s'inscrire, mais ces deux features ont été mises en commentaires pour le moment, le programme visant les végétariens uniquement.
Idéalement le projet devrait être fini en septembre 2021, avec des tests lors du semestre précédent
Nous avons utilisé Composer pour installer phpmailer afin de gérer l'envoi de mail, la partie HTML/CSS a été faite de manière séparé du code PHP, qui utilise une database MySql dont le fichier de création se trouve dans src/database/bd_p_prod.sql

À noter que plusieurs types de comptes existent, en fonction de leur useRole : 100 étant le maximum, pour un super admin, et en dessous de 50 un user standard. uniquement possible de créer un utilisateur admin via la base mysql pour le moment

doit être fini pour rentrée septembre 2021, tests en printemps 2021

TODO List par ordre de priorité, de important à moindre :
Trivial-en cours :
- faire fonctionner error_log

Visuel :
- pas assez responsif
- page connexion : retravailler visuel
- vue admin faire calendrier plus joli

Fonctionnalités légères
- changer de semaine en mode admin
- vue admin : changer numéro de plat par le type (enum)
- manger sur place/emporter comme critère à ajouter

Fonctionnalités complexes :
- envoyer email/jour pour lendemain/surlendemain
- identifier personne via carte étudiant/eduvaud
- pas de vérification de compte
- mettre image pour plats via vue admin
