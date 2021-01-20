# ETMeaL
Projet en cours permettant la réservation de menus, et de table, à terme, à la cafétaria de l'ETML.
### Autres documentations et fichiers
Plus d'informations quant à la documentation du projet se trouve sur K:\INF\Eleves\Classes\FIN2\02_P_PROD\adrbarreira_simguggisberg. 

Le dossier contient également un fichier de configuration contenant les accréditations email, et informations confidentielles ne pouvant se trouver sur github. Ce fichier est à mettre dans le fichier parent de celui contenant le projet. Ainsi, si l'arborescence est la suivante pour le répertoire : uwamp\www\P_Prod alors le fichier de configuration devrait être donc dans uwamp\www, se nommant configConfidential.ini.php.

### Fonctionnalités
Le cahier des charges de ce projet projet était d'abord de permettre aux végétariens de pouvoir s'inscrire à la cafétaria, puis au reste des clients. En spécifiant notamment le numéro de la table souhaitée, le menu, l'heure, le jour et enfin le nom de la personne. Certaines de ces données ont été laissées en commentaire pour le moment, ce site s'adressant aux végétariens uniquement.

Une fois une commande effectuée par un client, un courriel est envoyé aux addresses mail mentionnées dans le fichier de configuration, voir point précédent pour plus d'informations. Les utilisateurs ne peuvent pas accéder à la partie administration et vice-versa. Les deux options spécifiques aux utilisateurs sont de se déconnecter ou de passer une commande. Les trois options des admins sont :
- de se déconnecter
- de consulter un récapitulatif des commandes d'aujourd'hui. note : ne s'applique qu'aux menus actuels, si une commande a été passée avec un menu qui n'est plus à jour. alors cette réservation ne sera pas comptée.
- de consulter la liste des commandes complètes passées cette semaine, qui se réactualise automatiquemenet chaque semaine, tout comme le footer copyright, se mettant à jour automatiquement.

Idéalement le projet devrait être fini en septembre 2021, avec des tests lors du semestre de printemps.
 
 Ce projet est actuellement hébergé sur le serveur gesteleves et n'est donc qu'accessible via le réseau local. Ultimement il devrait être hébergé sur un serveur externe à l'etml, afin de pouvoir s'y connecter via smartphones et de passer commande plus facilement.

### Outils utilisés
- Composer est utilisé pour installer phpmailer afin de gérer l'envoi de mail.
- La partie HTML/CSS a été faite de manière séparé du code PHP, qui utilise un framework MVC custom ETML.
- Une base de données MySql gère les utilisateurs et les réservations, le fichier de création de celle-ci est src/database/bd_etmeal.sql.
- Bootstrap pour tout ce qui est styles et rendre le site responsif.

### Notes
Deux types de comptes existent, défini en fonction de leur useRole; la convention est la suivante : 100 étant le maximum, pour un super admin, et en dessous de 50 un user standard. Il est uniquement possible de modifier useRole via la basede données mysql pour le moment, un compte admin a déjà été créé, son mot de passe se trouve dans le fichier configConfidential.ini.php dans le dossier parent (voir point autres documentations et fichiers pour plus de détails).

Les parties du code concernant le choix de tables ou d'autres plats lors d'une commande ainsi que le formulaire de contact ont été mis en commentaires, souvent par choix (le site s'adressant d'abord au moindre nombre de végétariens), mais peut être aussi par manque d'implémentation.

### Simple Setup Uwamp
1. téléchargez et installez uwamp https://www.uwamp.com/fr/?page=download version exe (ou en version zip, il faut alors l'extraire)
2. clonez répertoire git https://github.com/GuggisbergSimon/P_PROD (bouton vert/Code puis download zip)
3. mettre le dossier de projet dans le dossier www d'uwamp
4. exécutez uwamp, sélectionnez la version de php : 7.0.3
5. dans uwamp, sélectionner phpmyadmin
6. connectez vous avec "root" et "root" comme usename/password
7. importez une base de données, avec le fichier suivant : https://github.com/GuggisbergSimon/P_PROD/blob/main/src/database/bd_etmeal.sql
8. Rendez vous sur le site internet en cliquant sur le bouton "navigateur www" puis le lien P_PROD, les étapes suivantes sont optionnelles, pour créer un autre compte administrateur
9. Créez un utilisateur via connexion -> inscription
10. Retournez sur la base de données mysql, se rendre dans t_user et modifiez un user existant avec droits supérieurs à 50, pour qu'il soit administrateur.

## TODO
Bugs connus :
- des utilisateurs peuvent commander un plat puis le plat peut être changé sans qu'ils ne le sachent. de plus la vue admin récapitulatif ne comptera que le plat actuel. Plusieurs solutions :
  - t_meal : ajouter champ deadline, à compléter en vue admin lors de changements de plats, n'accepter commande pour le plat donné que si dans la deadline
  - vue admin : lorsque changements de menus, prévenir si réservation dans le futur avec ces plats avant d'effectuer le changement
  - vue admin : lister tous les types de plats dans récapitulatif
  - vue utilisateur : restreindre commande à semaine courante

Fonctionnalités légères :
- vue admin : rendre tableau mieux responsive (pour petites devices)
- vue admin : ajouter options pour promouvoir utilisateur en tant qu'admin
- vue admin : ajouter changement de semaines pour le tableau (flèches gauche/droite)
- vue user : voir l'ensemble de commandes passées + en annuler (pas dispo le matin même)
- vue user : ajouter options de gestion de compte (suppression, reset mdp, etc)
- vue user : empêcher sélection de dates lors de vacances/fériés scolaires
- t_reservation : ajouter champ "créé le [date]"
- t_reservation : ajouter champ "manger sur place/à l'emporter"
- serveur : créer nouvelle adresse mail (sans "test" dans son nom)
- serveur : Mettre plus d'error_log pour mieux suivre erreurs serveur

Fonctionnalités complexes :
- vue admin : générer récapitulatif détaillé pdf puis l'envoyer par mail aux responsables via un bouton
- vue admin/user : ajouter image pour plats
- serveur : envoyer un email/jour récapitulatif (à minuit) pour les commandes du lendemain/surlendemain
- sécurité : identifier personne via carte étudiant/eduvaud (déterminer manière de vérifier)
- sécurité : vérifier le compte via email
