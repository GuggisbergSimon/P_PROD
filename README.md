# Site restaurant
Projet en cours permettant la réservation de menus, et de table, à terme, à la cafétaria de l'ETML.
##Autres documentations et fichiers
Plus d'informations quant à la documentation du projet se trouve sur K:\INF\Eleves\Classes\FIN2\02_P_PROD\adrbarreira_simguggisberg. 

Le dossier contient également un fichier de configuration contenant les accréditations email, informations confidentielles ne pouvant se trouver sur github. Ce fichier est à mettre dans le fichier parent de celui contenant le projet. Ainsi, si l'arborescence est la suivante pour le répertoire : uwamp\www\P_Prod alors le fichier de configuration devrait être donc dans uwamp\www

##Fonctionnalités
Le cahier des charges de ce projet projet était d'abord de permettre aux végétariens de pouvoir s'inscrire à la cafétaria, puis au reste des clients. En spécifiant notamment le numéro de la table souhaitée, le menu, l'heure, le jour et enfin le nom de la personne. Certaines de ces données ont été laissées en commentaire pour le moment, ce site s'adressant aux végétariens uniquement.

Une fois une commande effectuée par un client, un courriel est envoyé à une addresse mail mentionnée dans le fichier de configuration mentionné au point précédent. Les utilisateurs ne peuvent pas accéder à la partie administration et vice-versa. Les deux options spécifiques aux utilisateurs sont de se déconnecter ou de passer une commande. Les deux options des admins sont de se déconnecter et de consulter la liste des commandes passées cette semaine, qui se réactualise automatiquemenet chaque semaine, tout comme le footer copyright, se mettant à jour automatiquement.

Idéalement le projet devrait être fini en septembre 2021, avec des tests lors du semestre de printemps.

##Outils utilisés
- Composer est utilisé pour installer phpmailer afin de gérer l'envoi de mail.
- La partie HTML/CSS a été faite de manière séparé du code PHP, qui utilise un framework MVC custom ETML.
- Une base de données MySql gère les utilisateurs et les réservations, le fichier de création de celle-ci est src/database/bd_p_prod.sql.
- Bootstrap pour tout ce qui est styles et rendre le site responsif.

###Notes
Deux types de comptes existent, défini en fonction de leur useRole; la convention est la suivante : 100 étant le maximum, pour un super admin, et en dessous de 50 un user standard. Il est uniquement possible de modifier useRole via la basede données mysql pour le moment.

Les parties du code concernant le choix de tables ou d'autres plats lors d'une commande ainsi que le formulaire de contact ont été mis en commentaires, souvent par choix (le site s'adressant d'abord au moindre nombre de végétariens), mais peut être aussi par manque d'implémentation.

##Simple Setup Uwamp
1. téléchargez et installez uwamp https://www.uwamp.com/fr/?page=download version exe (ou en version zip, il faut alors l'extraire)
2. clonez répertoire git https://github.com/GuggisbergSimon/P_PROD (bouton vert/Code puis download zip)
3. mettre le dossier de projet dans le dossier www d'uwamp
4. exécutez uwamp, sélectionnez la version de php : 7.0.3
5. dans uwamp, sélectionner phpmyadmin
6. connectez vous avec "root" et "root" comme usename/password
7. importez une base de données, avec le fichier suivant : https://github.com/GuggisbergSimon/P_PROD/blob/main/src/database/bd_p_prod.sql
8. Rendez vous sur le site internet en cliquant sur le bouton "navigateur www" puis le lien P_PROD
9. Créez un utilisateur via connexion -> inscription
10. Retournez sur la base de données mysql, se rendre dans t_user et modifiez un user existant avec droits supérieurs à 50, pour qu'il soit administrateur.
 
##TODO
Bugs connus :

Améliorations visuelles :
- Footer pas responsif
- Feedback une fois le compte créé
- Erreurs de connexion/envoi de form à retravailler
- petit problème d'affichage en mode responsive, il faut appuyer 2x sur le menu hamburger

Fonctionnalités légères :
- compter le nombre de plats par jour (autre ligne)
- changer de semaine en mode admin
- Mettre plus d'error_log
- manger sur place/emporter comme critère à ajouter

Fonctionnalités complexes :
- envoyer email/jour pour lendemain/surlendemain
- identifier personne via carte étudiant/eduvaud
- pas de vérification de compte
- mettre image pour plats via vue admin
