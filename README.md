# New Daily Boost

Application web développée avec Symfony permettant de consulter, gérer et enregistrer des citations inspirantes à travers une interface sécurisée, responsive et accessible aux visiteurs comme aux utilisateurs authentifiés.

Le projet a été réalisé dans le cadre de ma formation Graduate Développeur Web Full Stack afin de mettre en pratique le développement d'une application Symfony complète, de sa conception jusqu'à son déploiement en production.

---

## Objectifs

Daily Boost a été conçu afin de mettre en pratique :

* l'architecture MVC avec Symfony ;
* le développement d'un CRUD ;
* la gestion des données avec PostgreSQL et Doctrine ORM ;
* la création et la gestion de comptes utilisateurs ;
* l'authentification et la gestion des rôles ;
* la sécurisation d'une application web ;
* la gestion des favoris pour les utilisateurs connectés et les visiteurs anonymes ;
* la conception d'interfaces responsives avec Twig, HTML et CSS ;
* l'utilisation de Git et GitHub avec un workflow par branches ;
* la gestion des migrations Doctrine ;
* le déploiement d'une application Symfony et d'une base PostgreSQL sur Railway ;
* la prise en compte des obligations relatives à la protection des données personnelles.

## Fonctionnalités

### Citations

* consulter l'ensemble des citations ;
* afficher une citation quotidienne ;
* afficher une citation aléatoire avec la fonction « Inspire-moi » ;
* ajouter une citation pour un utilisateur authentifié ;
* modifier une citation en tant qu'administrateur ;
* supprimer une citation en tant qu'administrateur ;
* consulter des statistiques.

### Favoris

* ajouter une citation aux favoris ;
* retirer une citation des favoris ;
* consulter ses citations favorites ;
* gestion des favoris pour les utilisateurs connectés ;
* gestion des favoris pour les visiteurs anonymes grâce à un identifiant stocké en session.

Les favoris d'un utilisateur sont automatiquement supprimés lors de la suppression de son compte grâce à une contrainte PostgreSQL ON DELETE CASCADE.

### Authentification et comptes utilisateurs

* inscription ;
* connexion ;
* déconnexion ;
* hashage sécurisé des mots de passe ;
* gestion des rôles ROLE_USER et ROLE_ADMIN ;
* restrictions d'accès avec les mécanismes de sécurité Symfony ;
* affichage conditionnel des fonctionnalités selon le profil connecté ;
* suppression définitive du compte par l'utilisateur ;
* protection de la suppression du compte par un jeton CSRF ;
* invalidation de la session après suppression.

### Interface

* Navigation dynamique ;
* Formulaires Symfony personnalisés ;
* Design responsive ;
* Adaptation mobile ;
* affichage conditionnel selon l'état de connexion ;
* pages légales accessibles depuis le footer.

---

## Sécurité

Daily Boost intègre plusieurs mécanismes de sécurité :

* authentification Symfony ;
* hashage des mots de passe ;
* protection CSRF ;
* contrôle des rôles ;
* restrictions d'accès avec IsGranted ;
* limitation des actions sensibles aux utilisateurs autorisés ;
* cookies de session configurés avec :
```yaml
cookie_secure: auto
cookie_httponly: true
cookie_samesite: lax
```

* suppression sécurisée du compte utilisateur ;
* suppression automatique des favoris associés au compte via PostgreSQL.

---

## Protection des données personnelles

Daily Boost collecte volontairement un nombre limité de données personnelles.

Les données associées à un compte sont principalement :

* adresse e-mail ;
* mot de passe sous forme hachée ;
* rôle utilisateur ;
* favoris associés au compte.

L'application ne collecte pas de nom, prénom, adresse postale ou numéro de téléphone lors de l'inscription.

Les éléments suivants ont été intégrés :

* politique de confidentialité ;
* mentions légales ;
* conditions d'utilisation ;
* information relative au traitement des données lors de l'inscription ;
* acceptation des conditions d'utilisation ;
* possibilité pour l'utilisateur de supprimer son compte ;
* suppression des données associées au compte ;
* mécanismes de session strictement nécessaires au fonctionnement de l'application.

Aucun traceur publicitaire ou outil de profilage n'est utilisé dans la version actuelle de Daily Boost.

Dans sa version actuelle, Daily Boost utilise uniquement des mécanismes de session nécessaires à son fonctionnement et ne met en œuvre aucun traceur nécessitant un consentement préalable.

Contact relatif aux données personnelles :

milady2.01@outlook.com

---

## Stack technique

### Back-end
* PHP 8
* Symfony 7
* Doctrine ORM
* Doctrine Migrations
* Symfony Security

### Base de données
* PostgreSQL

### Front-end
* Twig
* HTML5
* CSS3

### Outils
* Git
* GitHub
* Composer
* Symfony CLI
* DBeaver
* Railway
* Visual Studio Code

---

## Architecture

L'application repose sur une architecture MVC.

### Modèle

Principales entités Doctrine :

* User
* Quote
* Favorite

### Vues
Templates Twig organisés notamment dans :

templates/
├── home/
├── quote/
├── registration/
├── security/
└── legal/

### Contrôleurs
Principaux contrôleurs :

src/Controller/
├── BoostController.php
├── RegistrationController.php
├── SecurityController.php
├── AccountController.php
└── LegalController.php

BoostController gère principalement les citations et les favoris.

RegistrationController gère la création des comptes.

SecurityController gère l'authentification.

AccountController permet notamment la suppression sécurisée d'un compte utilisateur.

LegalController gère les pages relatives aux informations légales et à la protection des données.

---

## Base de données

Daily Boost utilise PostgreSQL avec Doctrine ORM.

Les principales tables sont :

* user
* quote
* favorite
* doctrine_migration_versions

Les migrations sont stockées dans :

migrations/

Une contrainte ON DELETE CASCADE est utilisée entre :

favorite.owner_id → user.id

Ainsi, les favoris rattachés à un utilisateur sont automatiquement supprimés avec son compte.

---

## Installation

1. Cloner le projet :

```bash
git clone https://github.com/Milady28002/Daily_boost.git
cd daily_boost
```

2. Installer les dépendances :

```bash
composer install
```

3. Configurer l'environnement local
Créer ou compléter le fichier `.env.local`

Exemple :
```markdown
```dotenv
DATABASE_URL="pgsql://USER:PASSWORD@127.0.0.1:5432/new_daily_boost?serverVersion=18&charset=utf8"
DATABASE_SERVER_VERSION=18
```

Les identifiants réels ne doivent pas être versionnés dans Git.

4. Créer la base :

```bash
php bin/console doctrine:database:create
```
5. Exécuter les migrations

```bash
php bin/console doctrine:migrations:migrate
```

6. Charger éventuellement les données de démonstration :

```bash
php bin/console doctrine:fixtures:load
```

7. Vérifier le schéma

```bash
php bin/console doctrine:schema:validate
```

8. Lancer le serveur Symfony :

```bash
symfony server:start
```
L'application est alors accessible localement, généralement sur :

http://127.0.0.1:8000

---

## Déploiement Railway

Daily Boost est déployé sur Railway.

L'environnement de production comporte deux services principaux :

Daily_boost
    │
    └── PostgreSQL

L'application Symfony et PostgreSQL sont déployés dans la région :

EU West — Amsterdam, Netherlands

Dépôt GitHub

Railway est relié au dépôt GitHub :

Milady28002/Daily_boost

La branche de production est :

main

Le workflow Git utilisé est :
```bash
feature/*
    ↓
   dev
    ↓
  main
    ↓
Railway
```

## Déploiement contrôlé

Les déploiements automatiques Railway peuvent être désactivés afin de conserver un contrôle manuel sur la mise en production.

Dans ce cas :

1. les modifications sont développées sur une branche feature/* ;
2. la branche feature est fusionnée dans dev ;
3. dev est fusionnée dans main ;
4. main est poussée vers GitHub ;
5. le dernier commit est ensuite déployé manuellement sur Railway avec Deploy Latest Commit.

Cette méthode évite qu'un simple push sur main rende immédiatement une nouvelle version publique.

---

## Migrations en production

Railway exécute automatiquement les migrations Doctrine avant le lancement d'un nouveau déploiement.

Commande configurée dans Pre-deploy Command :

```bash
php bin/console doctrine:migrations:migrate --no-interaction
```

Le processus de déploiement est donc :

GitHub main
      ↓
Railway Build
      ↓
Pre-deploy
      ↓
Doctrine Migrations
      ↓
Symfony
      ↓
PostgreSQL

Une migration échouée empêche le démarrage de la nouvelle version, ce qui évite de déployer l'application avec un schéma de base incompatible.

---

## Environnement de production

Principales variables utilisées sur Railway :
```markdown
```text
APP_ENV
APP_SECRET
DATABASE_URL
DATABASE_SERVER_VERSION
COMPOSER_ALLOW_SUPERUSER
RAILPACK_PHP_EXTENSIONS
RAILPACK_PHP_ROOT_DIR
```

Les valeurs sensibles sont définies directement dans Railway et ne sont pas stockées dans le dépôt Git.

---

## Commandes utiles

Vérifier la syntaxe YAML :
```bash
php bin/console lint:yaml config/packages/framework.yaml
```
Vérifier les templates Twig :
```bash
php bin/console lint:twig templates/
```
Vérifier la cohérence Doctrine :
```bash
php bin/console doctrine:schema:validate
```
Vérifier les migrations :
```bash
php bin/console doctrine:migrations:status
```
Vider le cache Symfony :
```bash
php bin/console cache:clear
```
Vérifier le projet Railway associé :
```bash
railway status
```
---

## Évolutions possibles

Plusieurs évolutions pourraient être envisagées :

* API REST afin d'exposer les données à une autre application ;
* espace de gestion du profil utilisateur ;
* notifications ou citations quotidiennes ;
* statistiques avancées ;
* amélioration de l'administration ;
* tests automatisés complémentaires ;
* amélioration de l'accessibilité ;
* gestion avancée des contenus utilisateurs.

---

## 👩‍💻 Auteur

Projet réalisé par Sylvie Mendez dans le cadre de ma formation Graduate Développeur Web Full Stack.
