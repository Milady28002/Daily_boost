# New Daily Boost

Application web développée avec Symfony permettant de gérer des citations inspirantes à travers une interface sécurisée et responsive.

---

## 🎯 Objectifs

* Ce projet a été réalisé dans le cadre de ma formation afin de mettre en pratique :

* l'architecture MVC avec Symfony
* le développement d'un CRUD complet
* la gestion des données avec PostgreSQL et Doctrine ORM
* la sécurisation d'une application web
* la gestion des utilisateurs et des rôles
* la conception d'interfaces responsives avec Twig

---

## ✨ Fonctionnalités

### Citations

* Ajouter une citation
* Consulter toutes les citations
* Modifier une citation
* Supprimer une citation
* Ajouter / retirer des favoris
* Afficher une citation aléatoire (“Inspire-moi”)
* Consulter des statistiques

### Authentification

* Inscription d'un utilisateur
* Connexion
* Déconnexion
* Gestion des rôles
* Restriction des actions sensibles aux administrateurs
* Affichage conditionnel des éléments de l'interface selon le profil connecté

### Interface

* Navigation dynamique
* Formulaires personnalisés
* Design responsive
* Adaptation mobile
---

## ⚙️ Stack technique

* Symfony 7
* PHP 8
* Doctrine ORM
* PostgreSQL
* Twig
* HTML5
* CSS3
* Git / GitHub

---

## 🔒 Sécurité

L'application intègre :

* Authentification Symfony
* Hashage des mots de passe
* Protection CSRF
* Gestion des rôles (ROLE_ADMIN)
* Contrôle d'accès avec IsGranted
* Masquage des actions sensibles pour les utilisateurs non autorisés

---

## 🏗️ Architecture

Architecture MVC :

* **Modèle** : entité `Quote` (Doctrine)
* **Vue** : templates Twig
* **Contrôleur** : `BoostController`

---


## 🚀 Installation

1. Cloner le projet :

```bash
git clone https://github.com/Milady28002/Daily_boost.git
cd daily_boost
```

2. Installer les dépendances :

```bash
composer install
```

3. Configurer la base de données dans `.env`

4. Créer la base :

```bash
php bin/console doctrine:database:create
```

5. Créer la base :
```bash
php bin/console doctrine:migrations:migrate
```

6. Charger les données :

```bash
php bin/console doctrine:fixtures:load
```

6. Lancer le serveur :

```bash
symfony server:start
```

---

## 🚀 Évolutions possibles


* API REST
* Gestion des profils utilisateurs*
* Notifications quotidiennes
* statistiques avancées

---

## 👩‍💻 Auteur

Projet réalisé par Sylvie Mendez dans le cadre de ma formation Graduate Développeur Web Full Stack.
