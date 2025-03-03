# README – MicroEcom Valorant

Ce projet est un **mini-site d’achat-revente** d’objets Valorant, développé en PHP suivant une architecture MVC et utilisant PostgreSQL pour la base de données. Il inclut :

- **Authentification** (inscription/connexion)
- **Création d’annonces** (produits)
- **Messagerie** (système de conversations entre utilisateurs)
- **Panel administrateur** (gestion des comptes et modération)
- **Système d’avis** (après achat)

Ce README vous guide pas à pas pour faire fonctionner le projet sur votre PC.

---

## 1. Prérequis

- **PHP** ≥ 7.4 (idéalement PHP 8.x)
- **Composer** (gestionnaire de dépendances PHP)
- **PostgreSQL**
- **Extensions PHP** : `pdo` et `pdo_pgsql`
- **Git** (pour cloner le dépôt)

*(Optionnel) Docker : Vous pouvez également utiliser Docker Compose pour lancer le projet avec des conteneurs pour PHP/Apache et PostgreSQL.*

---

## 2. Installation

### a) Cloner le dépôt

Ouvrez votre terminal et exécutez :

```bash
git clone <URL_DU_REPO> microecom
cd microecom
```

### b) Installer les dépendances Composer

Dans le dossier racine du projet, exécutez :

```bash
composer install
Cela installera toutes les bibliothèques requises dans le dossier vendor/.
```

### c) Créer le fichier d’environnement

À la racine du projet, créez un fichier nommé .env avec le contenu suivant (modifiez les valeurs si nécessaire) :

```env
DB_HOST=localhost
DB_NAME=microecom
DB_USER=postgres
DB_PASS=010924Apple
```

### d) Créer la base de données

Utilisez PostgreSQL pour créer la base de données. Par exemple, depuis le terminal :

```bash
createdb microecom
```

### e) Importer le script SQL

Importez le fichier SQL qui crée les tables (supposé être nommé db.sql) :

```bash
psql -U postgres -d microecom -f db.sql
```

(Vous pouvez également utiliser un outil graphique comme Adminer ou pgAdmin.)

## 3. Configuration du serveur web

### Option A – Serveur local (Apache/Nginx)

Configurez un vhost ou utilisez le dossier du projet pour que le DocumentRoot pointe vers le dossier public/.
Assurez-vous que mod_rewrite (ou l’équivalent) est activé si vous utilisez des routes personnalisées.

### Option B – Serveur PHP intégré

Pour lancer le projet rapidement, exécutez la commande suivante à la racine du projet :

```bash
php -S localhost:8080 -t public
```
Accédez ensuite à http://localhost:8080 dans votre navigateur.

## 4. Utilisation

- Page d’accueil : Affiche le hero et des informations introductives.
- Inscription : Rendez-vous sur ?action=register pour créer un compte.
- Connexion : Rendez-vous sur ?action=login pour vous connecter.
- Produits : ?action=products affiche la liste des annonces sous forme de cartes.
- Messagerie : ?action=messages affiche vos conversations groupées par produit. Cliquez sur une conversation pour l’ouvrir.
- Admin : ?action=admin ouvre le panel administrateur (accessible si vous êtes connecté en tant qu’admin).

## 5. Compte administrateur par défaut

### Le projet configure automatiquement un compte administrateur si vous vous inscrivez avec l’adresse email test@test.com.

- Email : test@test.com
- Mot de passe : test

## 6. Arborescence rapide du projet

```pgsql
microecom/
├── db.sql
├── .env
├── composer.json
├── composer.lock
├── public/
│   ├── index.php
│   └── css/
│       └── style.css
├── src/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── ProductController.php
│   │   ├── MessageController.php
│   │   ├── AdminController.php
│   │   └── RatingController.php
│   ├── Models/
│   │   ├── Database.php
│   │   ├── User.php
│   │   ├── Product.php
│   │   └── Message.php
│   ├── Views/
│   │   ├── layout.php
│   │   ├── home.php
│   │   ├── products/
│   │   │   └── index.php
│   │   └── messages/
│   │       ├── index.php
│   │       └── conversation.php
│   └── Router.php
└── vendor/
```

## 7. Démarrage du projet

Démarrer la session : Le fichier public/index.php démarre la session (appel unique).
Lancer le serveur (via Apache/Nginx ou PHP intégré, comme expliqué en section 3).

## 8. Commandes récapitulatives

### Cloner le projet :
```
git clone <URL_DU_REPO> microecom
cd microecom
```

### Installer Composer :
```
composer install
```
### Créer la base de données :
```
createdb microecom
```
### Importer le script SQL :
```
psql -U postgres -d microecom -f db.sql
```
### Lancer le serveur PHP intégré (optionnel) :
```
php -S localhost:8080 -t public
```
Accéder au site : http://localhost:8080

## 9. Personnalisation et développement

Modifications CSS : Le fichier public/css/style.css contient le design global (header, footer, hero, cartes produits, messagerie, chat, etc.). Vous pouvez le personnaliser selon vos besoins.
Contrôleurs et vues : Suivez l’architecture MVC pour ajouter ou modifier des fonctionnalités.
Sécurité : Ce projet est un exemple pédagogique. En production, ajoutez des validations supplémentaires (ex. tokens CSRF, validation des entrées).

## 10. Support et contributions

Pour toute question ou contribution, veuillez ouvrir une issue sur le dépôt GitHub du projet.
