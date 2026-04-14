# New Daily Boost

Application web développée avec Symfony permettant de gérer des citations inspirantes.

---

## 🖼️ Aperçu
![Aperçu de l'application](https://github.com/user-attachments/assets/ddc15705-08ab-4077-9b47-2ee51ed52213)

---

## 🎯 Objectif

Ce projet a été réalisé dans le cadre de ma formation afin de mettre en pratique :

* un CRUD complet
* la gestion d’une base de données avec PostgreSQL
* l’architecture MVC avec Symfony

---

## ✨ Fonctionnalités

* Ajouter une citation
* Consulter toutes les citations
* Modifier une citation
* Supprimer une citation
* Ajouter / retirer des favoris
* Afficher une citation aléatoire (“Inspire-moi”)
* Consulter des statistiques

---

## ⚙️ Stack technique

* Symfony 7
* Doctrine ORM
* PostgreSQL
* Twig
* HTML / CSS

---

## 🏗️ Architecture

Architecture MVC :

* **Modèle** : entité `Quote` (Doctrine)
* **Vue** : templates Twig
* **Contrôleur** : `BoostController`

---

## 👤 Utilisation

L’application est conçue pour un usage individuel.

En l’absence d’authentification, toutes les données sont globales (pas de gestion multi-utilisateur).

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
php bin/console doctrine:migrations:migrate
```

5. Charger les données :

```bash
php bin/console doctrine:fixtures:load
```

6. Lancer le serveur :

```bash
symfony server:start
```

---

## 💥 Problèmes rencontrés

Lors du développement, j’ai rencontré un problème de connexion à PostgreSQL.

Solution :

* réinstallation complète du service
* recréation de la base
* relance des migrations et fixtures

---

## 🚀 Évolutions possibles

* authentification utilisateur
* API REST
* frontend dynamique (React / Vue)
* statistiques avancées

---

## 👩‍💻 Auteur

Projet réalisé par Sylvie Mendez dans le cadre de ma formation Développeur Web Full Stack.
