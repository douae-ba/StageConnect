# StageConnect - Plateforme de Gestion de Stage

[cite_start]Projet de stage réalisé dans le cadre de la formation en **Génie Informatique** à l'**École Nationale des Sciences Appliquées (ENSA) d'Oujda**[cite: 286, 289]. [cite_start]Le stage a été effectué au sein du Service Informatique du **Centre Hospitalier Universitaire (CHU) Mohammed VI d'Oujda**[cite: 300, 301].

## 🎯 Objectif du Projet

[cite_start]"StageConnect" est une application web conçue pour **faciliter le suivi et la gestion des stages** au sein de l'établissement[cite: 290, 329]. [cite_start]L'outil vise à simplifier et centraliser les échanges et la coordination entre les quatre acteurs principaux[cite: 330]:

* [cite_start]Le **Stagiaire** [cite: 330]
* [cite_start]L'**Encadrant Pédagogique** (Professeur) [cite: 330]
* [cite_start]L'**Encadrant Professionnel** [cite: 330]
* [cite_start]Le **Service des Ressources Humaines** (Administrateur) [cite: 330]

## 🛠️ Stack Technique

[cite_start]Le projet est développé sur une architecture **MVC** [cite: 479] en utilisant les technologies suivantes :

* [cite_start]**Backend:** PHP, Framework **Symfony** [cite: 423, 462, 673]
* [cite_start]**Frontend:** HTML5, CSS3, JavaScript, Bootstrap [cite: 436, 442, 451, 457, 673]
* [cite_start]**Base de données:** **MySQL** [cite: 429, 672]
* [cite_start]**Conception & Modélisation:** **UML** (Diagrammes de cas d'utilisation et de classes) [cite: 515, 517, 537]
* [cite_start]**Serveur local (Dev):** WampServer [cite: 429, 670]
* [cite_start]**IDE & Outils:** Visual Studio Code, Draw.io [cite: 678, 679]

## ✨ Fonctionnalités Principales

L'application est divisée en plusieurs espaces sécurisés par un système d'authentification.

* **Authentification & Sécurité**
    * [cite_start]Page de connexion pour tous les utilisateurs[cite: 696].
    * [cite_start]Fonctionnalité "Mot de passe oublié" avec envoi de lien par email[cite: 699, 714, 715].
* **Espace Administrateur (RH)**
    * [cite_start]**Dashboard** avec statistiques (nombre total de stagiaires, d'encadrants, de stages en cours) [cite: 717-720].
    * [cite_start]**Gestion des Stagiaires :** Liste détaillée des stagiaires [cite: 721] [cite_start]et formulaire pour ajouter un nouveau stagiaire avec les informations de son stage (encadrants, dates, sujet)[cite: 844, 852].
    * [cite_start]**Gestion des Utilisateurs :** Formulaire pour créer de nouveaux comptes utilisateurs (Stagiaire, Encadrant, Professeur) et leur assigner des rôles[cite: 899, 903].
* **Espace Stagiaire**
    * [cite_start]**Messagerie :** Interface de chat pour communiquer séparément avec l'Encadrant et le Professeur[cite: 993, 1000, 1001].
    * [cite_start]**Dépôt de fichiers :** Module pour déposer des documents (rapports, etc.) à l'attention de l'encadrant, avec un historique des dépôts [cite: 993, 1007-1011].
* **Espace Encadrant (Professionnel)**
    * [cite_start]**Suivi :** Accès à une interface de chat pour communiquer directement avec les stagiaires assignés[cite: 1046, 1054].
    * [cite_start]Visualisation des messages et de l'historique des échanges[cite: 1057].
* **Espace Professeur (Pédagogique)**
    * [cite_start]**Suivi :** Interface de chat pour communiquer avec l'étudiant[cite: 1103].
    * [cite_start]**Supervision :** Accès à la discussion entre le stagiaire et son encadrant professionnel pour suivre l'avancement[cite: 1103].

## 🏗️ Architecture

[cite_start]Le projet suit une architecture logicielle **MVC (Modèle-Vue-Contrôleur)**[cite: 479, 480].

* **Modèle (Model):** Gère les données et la logique métier. [cite_start]Correspond aux entités (ex: `User`, `Stage`, `Message`) et aux interactions avec la base de données MySQL [cite: 490, 491, 539-593].
* **Vue (View):** Gère l'affichage et la présentation des informations à l'utilisateur. [cite_start]Réalisée en **Twig** (moteur de template de Symfony)[cite: 499, 500].
* **Contrôleur (Controller):** Assure la liaison entre le modèle et la vue. [cite_start]Reçoit les requêtes, appelle le modèle, et renvoie la réponse à la vue[cite: 504, 505].

[cite_start]La conception a été modélisée à l'aide de diagrammes **UML** (Cas d'utilisation, Classes, MLD)[cite: 515, 517, 537, 594].

## ⚙️ Installation & Setup (Pour Développeurs)

1.  **Cloner le dépôt :**
    ```bash
    git clone [https://github.com/douae-ba/StageConnect.git](https://github.com/douae-ba/StageConnect.git)
    cd StageConnect
    ```

2.  **Installer les dépendances (PHP) :**
    ```bash
    composer install
    ```

3.  **Configurer les variables d'environnement :**
    Créez un fichier `.env.local` à la racine et configurez votre base de données et votre service de messagerie (Mailer).
    ```env
    # .env.local
    DATABASE_URL="mysql://DB_USER:DB_PASSWORD@127.0.0.1:3306/DB_NAME?serverVersion=8.0"
    MAILER_DSN="smtp://USERNAME:PASSWORD@HOST:PORT"
    ```

4.  **Exécuter les migrations de la base de données :**
    ```bash
    php bin/console doctrine:migrations:migrate
    ```

5.  **Démarrer le serveur de développement :**
    ```bash
    symfony server:start
    ```

## ⚠️ Limitations (À compléter)

* L'application est actuellement configurée pour un seul établissement (le CHU d'Oujda) et n'est pas multi-tenant.
* La messagerie est un système d'échange simple et n'inclut pas de fonctionnalités de chat en temps réel (via WebSockets).
* La gestion des périodes de stage (ex: validation des dates par l'admin) n'est pas automatisée.

## 🚀 Roadmap (Évolutions possibles)

* **Chat en temps réel :** Intégrer un composant Symfony Mercure ou des WebSockets pour une messagerie instantanée.
* **Notifications :** Ajouter un système de notifications (email ou in-app) pour les nouveaux messages ou dépôts de fichiers.
* **Génération de PDF :** Automatiser la génération des attestations de stage.
* **Dashboard Admin Avancé :** Ajouter plus de statistiques et de graphiques.

## Guide de Déploiement en Production

Guide basique pour déployer une application Symfony.

### 1. Prérequis Serveur
* **PHP** (version compatible avec votre projet)
* **Base de données :** MySQL 8.0+ ou MariaDB
* **Serveur Web :** Nginx ou Apache
* **Composer** v2.x

### 2. Récupération du code & Installation
```bash
# Clonez votre projet
git clone [https://github.com/douae-ba/StageConnect.git](https://github.com/douae-ba/StageConnect.git)
cd StageConnect

# Installez les dépendances pour la production (sans les outils de dev)
composer install --no-dev --optimize-autoloader
