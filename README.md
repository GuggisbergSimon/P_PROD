# Application Cafetaria
Projet en cours de progrès pour permettre la réservation de menus, et de table, à terme, à la cafétaria de l'ETML. Plus d'informations via la documentation se trouvant dans le K/INF/...

Le projet était d'abord de permettre aux végétariens de pouvoir s'inscrire à la cafétaria, puis au reste des client, en spécifiant notamment, le numéro de la table souhaitée, le menu, l'heure, le jour et enfin le nom de la personne.
Idéalement le projet devrait être fini en septembre 2021, avec des tests lors du semestre précédent
Nous avons utilisé composer pour installer phpmailer afin de gérer l'envoi de mail, la partie HTML/CSS a été faite de manière séparé du code PHP, qui utilise une database MySql dont le fichier de création se trouve dans src/database/bd_p_prod.sql

À noter que plusieurs types de comptes existent, en fonction de leur useRights : 100 étant le maximum, pour un super admin, et en dessous de 50 un user standard, convention non indiquée donc possible de s'en écarter néanmoins.

TODO List :
- exposer paramètres pour admin 
- manger sur place/emporter comme critère à ajouter 
- fini rentrée septembre 2021, tests en printemps 2021 
- identifier personne via carte étudiant/eduvaud 
- WIP - envoyer email/jour pour lendemain/surlendemain 
- mettre image pour plats via vue admin   
- page connexion : retravailler 
- pas de vérification de compte 
- vue admin : changer numéro de pat par le type (enum) 
- vue admin faire calendrier plus joli 
- WIP - quand commande, envoyez un mail 
- Police ETML ne s'affiche pas selon navigateur/ordinateur 
- changer de semaine en mode admin 
- pas assez responsive 
- formulaire apropos ne fonctionne pas- à garder ? 
- faire fonctionner error_log 
- ETML font not always being displayed
