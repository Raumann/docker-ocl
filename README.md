# Docker ocl

Une première utilisation de docker au travers du jeu du memory

> Tapez en ligne de commande `docker-compose up --build`

> Puis créez la bdd (voir plus bas Commandes Mysql)

## Commandes docker

`docker -v` => pour savoir quelle version de docker est installée (et par conséquent savoir si docker est installé)

`docker images` => liste les images installées

`docker ps -a` => liste les containers installés

`docker build -t [image] .` => permet de créer une image en lui spécifiant son nom par exemple `docker build -t php_img .`
- `-t` permet de spécifier le tag de l'image (= nom)
- `.` est le path (`.` signifie le current directory)

Docker recommande de donner un nom au repository :
- `docker build -t php_repo:php_img .`

`docker run -p 8080:80 php_repo:php_img` => on lance l'image qui est désormais accessible via http://localhost:8080/

`docker run -p 8080:80 -v /Users/charleshoffmann/Sites/docker-ocl/src:/var/www/html php_repo:php_img` => permet de transférer le contenu du chemin spécifié à var/www/html car c'est le format fourni par l'image php (voir contenu docker-compose.yml)

`docker-compose up` => construit, créé les images (si pas encore construites), créé les containers à partir du fichier docker-compose.yml

`docker-compose up --build` => si on a modifié dockerfile et docker-compose

## Commandes Mysql

Après avoir lancé `docker-compose up --build`, ouvrir un autre terminal et tapez :
- `docker exec -it mysql-server-80  bash -l` => pour pouvoir se connecter à la partie server
- `mysql -u root -p` => pour se connecter à mysql
- mdp enregistré dans docker-compose.yml

SHOW DATABASES; => voir les bases de données

CREATE DATABASE memory; => permet de créer la base de donnée memory si elle n'y est pas

USE memory; => pour utiliser cette base de donnée

SHOW TABLES; => pour voir les tables

Voir fichier memory.sql pour remplir la base de donnée

DESCRIBE score; => pour voir si tout s'est bien passé 

On peut ensuite utiliser les commandes classiques suivant ce que l'on veut faire, par exemple :
- `SELECT * FROM score;` => pour voir les données contenues dans la table