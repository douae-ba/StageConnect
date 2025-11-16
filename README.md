# 🌐 StageConnect — Plateforme de Gestion de Stages

Projet réalisé au sein du **Service Informatique du Centre Hospitalier Universitaire (CHU) Mohammed VI d'Oujda** dans le cadre d'un stage professionnel.

---

## 🎯 Objectif du Projet

**StageConnect** est une application web permettant de **centraliser, suivre et gérer l’ensemble des processus liés aux stages** au sein de l’établissement.  
Elle facilite la communication et la coordination entre quatre acteurs principaux :

- 👩‍🎓 **Stagiaire**
- 👨‍🏫 **Encadrant Pédagogique** (Professeur)
- 🧑‍💼 **Encadrant Professionnel**
- 🏢 **Service des Ressources Humaines** (Administrateur)

---

## 🛠️ Stack Technique

Le projet repose sur une architecture **MVC**, construite avec les technologies suivantes :

**Backend :**
- PHP
- Framework **Symfony**

**Frontend :**
- HTML5 / CSS3
- JavaScript
- Bootstrap
- Twig

**Base de données :** MySQL  
**Environnement local :** WampServer  
**Outils :** Visual Studio Code, Draw.io

---

## ✨ Fonctionnalités Principales

L'application comprend plusieurs espaces dédiés, accessibles via un système d’authentification sécurisé.

### 🔐 Authentification & Sécurité
- Page de connexion commune  
- Fonction « Mot de passe oublié » avec envoi d’email  
- Gestion des rôles : Stagiaire, Encadrant, Professeur, Administrateur  

---

### 🏢 Espace Administrateur (RH)
- **Dashboard** : statistiques sur les stagiaires, encadrants et stages  
- **Gestion des Stagiaires** : ajout, consultation, affectation d’encadrants  
- **Gestion des Comptes Utilisateurs** : création de comptes + attribution des rôles  

---

### 👩‍🎓 Espace Stagiaire
- **Messagerie** avec encadrant professionnel et professeur  
- **Dépôt de fichiers** + historique  

---

### 🧑‍💼 Espace Encadrant Professionnel
- Messagerie avec les stagiaires suivis  
- Consultation de l’historique des échanges  

---

### 👨‍🏫 Espace Encadrant Pédagogique
- Messagerie avec le stagiaire  
- Accès à la conversation stagiaire ↔ encadrant professionnel  

---

## 🏗️ Architecture Logicielle

Le projet utilise le modèle **MVC** :

- **Modèle (Model)** : entités, logique métier, base MySQL  
- **Vue (View)** : templates **Twig**  
- **Contrôleur (Controller)** : traitement des requêtes et orchestration  

---

## ⚙️ Installation & Configuration

### 1. Cloner le projet
```bash
git clone https://github.com/douae-ba/StageConnect.git
cd StageConnect
```
## 2. Installer les dépendances
```bash
composer install
```
## 3.Configurer l’environnement
Créer un fichier .env.local :
```bash
DATABASE_URL="mysql://DB_USER:DB_PASSWORD@127.0.0.1:3306/stagiaire?serverVersion=8.0"
MAILER_DSN="smtp://USERNAME:PASSWORD@HOST:PORT"
```
## 4.Exécuter les migrations
```bash
php bin/console doctrine:migrations:migrate
```
## 5.Lancer le serveur de développement
```bash
symfony server:start
```

⚠️ Limitations
- Application dédiée à un seul établissement
- Messagerie non temps réel
- Gestion des périodes de stage non automatisée

🚀 Roadmap
- Chat en temps réel (Mercure / WebSockets)
- Notifications email et in-app
- Génération automatique de PDF
- Workflow automatique pour validation des stages

📦Déploiement en Production
1. Prérequis
- PHP compatible Symfony(8.2 ou plus)
- MySQL 8+ / MariaDB
- Serveur Nginx ou Apache
- Composer v2

2. Installation en production
 ```bash
git clone https://github.com/douae-ba/StageConnect.git
cd StageConnect

composer install --no-dev --optimize-autoloader
```

