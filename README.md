# Application Cafetaria
####Autres documentations et fichiers
Projet en cours de progrès pour permettre la réservation de menus, et de table, à terme, à la cafétaria de l'ETML. Plus d'informations quant à la documentation du projet se trouve sur K:\INF\Eleves\Classes\FIN2\02_P_PROD\adrbarreira_simguggisberg. 

Là-bas se trouve également un fichier de configuration contenant les accréditations email, informations confidentielles ne pouvant se trouver sur github. Ce fichier est à mettre dans le fichier parent de celui contenant le projet. Ainsi, si l'arborescence est la suivante : uwamp\www\P_Prod est ici se trouve le répertoire git. le fichier de configuration devrait être donc dans uwamp\www

####Fonctionnalités
Le cahier des charges de ce projet projet était d'abord de permettre aux végétariens de pouvoir s'inscrire à la cafétaria, puis au reste des client. En spécifiant notamment le numéro de la table souhaitée, le menu, l'heure, le jour et enfin le nom de la personne. Certaines de ces données ont été coupées pour le moment, ce site s'adressant aux végétariens uniquement.

Une fois une commande effectuée par un client, un mail est envoyé à une addresse mail mentionnée dans le fichier de configuration mentionné au point précédent. Les utilisateurs ne peuvent pas accéder à la partie administration et vice-versa. Les deux options spécifiques aux utilisateurs sont de se déconnecter ou de passer une commande. Les deux options aux admins sont de se déconnecter et de consulter la liste des commandes passées cette semaine, se réactualise automatiquemenet chaque semaine, tout comme le footer copyright, se mettant à jour à l'année d'aujourd'hui automatiquement.

Idéalement le projet devrait être fini en septembre 2021, avec des tests lors du semestre de printemps.

####Outils utilisés
- Composer est utilisé pour installer phpmailer afin de gérer l'envoi de mail.
- La partie HTML/CSS a été faite de manière séparé du code PHP, qui utilise un framework MVC custom ETML.
- Une base de données MySql gère les utilisateurs et les réservations, le fichier de création de celle-ci est src/database/bd_p_prod.sql.
- Bootstrap pour tout ce qui est styles et rendre le site responsif.

####Notes
Deux types de comptes existent, défini en fonction de leur useRole; la convention est la suivante : 100 étant le maximum, pour un super admin, et en dessous de 50 un user standard. uniquement possible de créer un utilisateur admin via la base mysql pour le moment.

Les parties du code concernant le choix de tables ou d'autres plats lors d'une commande ainsi que le formulaire de contact ont été mis en commentaires, ou par choix, le site s'adressant d'abord au petit nombre de végétariens, ou par manque d'implémentation, le formulaire n'envoyant actuellement pas de mail.

####Simple Setup Uwamp
1. clonez répertoire git https://github.com/GuggisbergSimon/P_PROD (bouton vert/Code puis download zip)
2. téléchargez uwamp https://www.uwamp.com/fr/?page=download version rar/zip
3. mettre le dossier de projet dans le dossier www d'uwamp
4. lancez uwamp, sélectionner php : 7.0.3 et sélectionnez navigateur www
5. naviguez jusqu'à la page index/home
6. dans uwamp, sélectionner phpmyadmin
7. connectez vous avec "root" et "root" comme usename/password
8. importez une database, avec le fichier suivant : https://github.com/GuggisbergSimon/P_PROD/blob/main/src/database/bd_p_prod.sql
9. Rendez vous sur le site internet
9. se rendre dans t_user et insérer un user admin, ou modifier un user existant, avec droits supérieurs à 50

##TODO
####Bugs connus :
- Conexion acceptée avec mauvais mdp
- Connexion avec username non existant crée une erreur

####Améliorations visuelles :
- Feedback une fois le compte créé
- Erreurs de connexion/envoi de form à retravailler
- petit problème d'affichage en mode responsive, il faut appuyer 2x sur le menu hamburger
- admin changer date en dd.MM.YYYY

####Fonctionnalités légères :
- compter le nombre de plats par jour (autre ligne)
- changer de semaine en mode admin
- Mettre plus d'error_log
- faire fonctionner formulaire de contact
- manger sur place/emporter comme critère à ajouter

####Fonctionnalités complexes :
- envoyer email/jour pour lendemain/surlendemain
- identifier personne via carte étudiant/eduvaud
- pas de vérification de compte
- mettre image pour plats via vue admin
