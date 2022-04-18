
# ECF Hypnos

Application développée dans le cadre de ma formation chez Studi. Il s'agit d'un site responsive pour un groupe hôtelier avec système de réservation.

Les documents annexes requis se trouvent dans le dossier **documents_ecf** à la racine du dépôt. Ce dossier comprend :
+ Dump de la base de donnée
+ Manuel d'utilisation
+ Documentation technique
+ Charte graphique

## Prérequis

Doivent être installés sur votre machine :

**Apache**

**PHP 8.1**

**Symfony 6.0**

**MySQL 8**

Nous vous invitons à consulter la documentation de ces services pour leur installation.

## Installation

Récupérez le projet via GIT clone

```bash
  git clone https://github.com/VariantT505/project_ecf.git
```

Déplacez-vous dans le dossier

```bash
  cd project_ecf
```
    
Installation des dépendances via les commandes

```bash
  npm install
  composer install
```
    
Un dump de la base de données MySQL locale est disponible dans le dossier **documents_ecf**. Nous vous invitons à l'installer sur votre machine

```bash
  mysql.server start
  mysql -u "username" -p "database_name" < documents_ecf/dump.sql
```
## Variables d'environnement

Pour faire tourner ce projet, vous aurez besoin de modifier le fichier .env se trouvant à la racine du dossier.

Décommentez la ligne commençant par

`DATABASE_URL="mysql://"`

Et remplacez les données par celles de votre base de données locale selon l'exemple suivant

`DATABASE_URL="mysql://db_user:dp_password@127.0.0.1:3306/database_name?serverVersion=8.0.28&charset=utf8mb4"`

La serverVersion doit correspondre à votre version de MySQL installée.
## Deploiement en local

Lancez le serveur Symfony

```bash
  Symfony server:start
```

Dans le cas où vous souhaiteriez effectuer des modifications des fichiers .scss et voir leur application immédiate, vous pouvez également lancer la commande

```bash
  npm run watch
```

## Deploiement sur Heroku

La commande suivante enverra vos modifications sur Heroku

```bash
  git add .
  git commit -m "mon commit"
  git push Heroku main
```

Notez que la base de données Prod (Heroku) est indépendante de la base de données Dev (locale) afin de pouvoir effectuer des tests en Dev sans impacter le site Prod.
Les données fournies dans le dump.sql sont cependant celles de bases et sont identiques en Dev et en Prod.
## Authors

- Thomas Dreidemy [@VariantT505](https://www.github.com/VariantT505)

