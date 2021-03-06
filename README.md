# Brocyclisme

![index](https://github.com/Gouderg/Brocyclisme/blob/master/front/img/indexSite.png)

Application web permettant au responsable d'un club cycliste de gérer des coureurs sur une saison. 


## Installation

### Dépendances

Vous devez posséder sur votre machine:
	
	* PHP version 7 ou supérieur
	* Un serveur Web (Apache)
	* MySQL

Le projet à été essayé sous WAMP et sous Linux.

## Mise en place du site

Le site possède sa propre base de donnée que vous devez charger afin de le rendre fonctionnel.
Après vous être rendu à la racine du site, allez dans votre terminal mysql et exécutez la commande suivante:
```sql
	SOURCE api/sql/bddGood.sql;
```
Tout est inclus dans ce fichier, mais si vous voulez changer les logins de connexion, vous pouvez changer les constantes dans le fichier api/php/constante.php
On peux également changer l'url de notre site dans front/js/constantes.js

### Mise en Place du VirtualHost

Le site fonctionne à l'aide de deux Virtualhosts, vous devez donc les créer sur votre machine.

Guide :

1) Rendez-vous dans /etc/apache2/sites-available
2) Créez deux répertoires prj-cir2-web-api.monposte.conf et prj-cir2-web-front.monposte.conf
3) Ouvrez un éditeur de texte et copiez les différentes commandes permettant la mise en place de votre Virtualhost:

prj-cir2-web-api.monposte.conf : (N'oubliez pas d'enregistrer !!)
	
	<VirtualHost *:80>
		ServerName prj-cir2-web-api.monposte
		DocumentRoot "/var/www/cir2web/api"
		ErrorLog ${APACHE_LOG_DIR}/error.log
		CustomLog ${APACHE_LOG_DIR}/access.log combined
		<Directory "/var/www/cir2web/api">
			Header set Access-Control-Allow-Origin "http://prj-cir2-web-front.monposte"
			Header set Access-Control-Allow-Methods "GET,POST,PUT,DELETE,OPTIONS"
			Require all granted
		</Directory>
	</VirtualHost>

prj-cir2-web-front.monposte.conf : (N'oubliez pas d'enregistrer !!)
	
	<VirtualHost *:80>
		ServerName prj-cir2-web-front.monposte       
		DocumentRoot "/var/www/cir2web/front"       
		ErrorLog ${APACHE_LOG_DIR}/error.log
		CustomLog ${APACHE_LOG_DIR}/access.log combined
	</VirtualHost>

4) Puis il faut rajouter les hosts. Pour cela ouvrez le fichier etc/hosts à l'aide d'un éditeur de texte.

On rajoute ces deux lignes en dessous du localhost:	

	  127.0.0.1		prj-cir2-web-api.monposte
	  127.0.0.1		prj-cir2-web-front.monposte

Si tout est bon, si vous faites un ping de votre url, vous devriez avoir une réponse du localhost. C'est signe que cela fonctionne

5) Enfin on retourne dans /etc/apache2/sites-available 

Dans votre terminal, entrez les deux commandes suivantes:
 
	  sudo a2ensite prj-cir2-web-front.monposte.conf
	  sudo a2ensite prj-cir2-web-api.monposte.conf

6) Pour finir on restart le serveur à l'aide de la commande suivante:

(Toujours dans votre terminal)

	  sudo service apache2 restart

Il pourra être intéréssant de faire la commande suivante necéssaire au bon fonctionnement du VirtualHost:
	  
	  sudo a2enmod headers 

Le VirtualHost est mis en place.


RAPPEL: Pensez à vérifier le status du serveur afin de voir si tout fonctionne correctement !! ( commande : sudo service apache2 status)


## Utilisation

Le site se veut simple d'utilisation.

Il permet visualiser la liste des coureurs d'un club, de les modifier, de les inscrire à une course et d’établir le classement
final d’une course du point de vue d'un responsable de club.

Il est constitué de deux parties : 

 * La première permettant au responsable du club de gérer les différents cyclistes de son club en visualisant leurs fiches 
	qu'il pourra modifier. 
 * La deuxième permettant au responsable du club de gérer les différentes courses à venir ou passées en s'informant sur la course, en inscrivant des cyclistes ou alors en visualisant le classement de la course passée (s'il s'agit de l'organisateur de la course).
