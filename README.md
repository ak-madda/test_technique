# TaskManager - Gestion de Projets et Tâches

Application full-stack développée avec **Laravel 10+** et **Vue.js 3** pour la gestion de projets et tâches, utilisant **SQLite** comme base de données.

## 🚀 Fonctionnalités

- ✅ **Authentification utilisateur** - Inscription, connexion et déconnexion
- ✅ **Gestion complète des projets** - CRUD pour les projets
- ✅ **Gestion complète des tâches** - CRUD pour les tâches avec assignation
- ✅ **Drag & Drop** - Glisser-déposer pour changer le statut des tâches
- ✅ **Interface responsive** - Design adaptatif avec Tailwind CSS
- ✅ **Gestion d'état** - Avec Pinia pour Vue.js
- ✅ **Validation des formulaires** - Coté client et serveur

## 🛠️ Stack Technique

### Backend
- **Laravel 10+** - Framework PHP
- **Laravel Sanctum** - Authentification API
- **SQLite** - Base de données légère
- **File-based queues** - Files d'attente

### Frontend
- **Vue.js 3** - Composition API
- **Vue Router** - Navigation
- **Pinia** - Gestion d'état
- **Axios** - Requêtes HTTP
- **Tailwind CSS** - Styling
- **HTML5 Drag & Drop** - Interface glisser-déposer

## 📋 Prérequis

- PHP 8.1+
- Composer
- Node.js 16+
- SQLite (inclus avec PHP)
- Git

## 🚀 Installation & Démarrage

### 1. Backend (Laravel avec SQLite)

```bash
# Cloner le projet
git clone <votre-repo>
cd backend-laravel

# Installer les dépendances
composer install

# Configurer l'environnement
cp .env.example .env
php artisan key:generate

# Configurer SQLite dans .env
# Editez le fichier .env et assurez-vous d'avoir:
DB_CONNECTION=sqlite
# Commentez les lignes MySQL:
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

# Créer la base de données SQLite
touch database/database.sqlite

# Exécuter les migrations et le seeding
php artisan migrate --seed

# Démarrer le serveur
php artisan serve

-

# front end

# Accéder au dossier frontend
cd frontend-vue

# Installer les dépendances
npm install

# Démarrer le serveur de développement
npm run dev

--
# compte de test

Après l'installation, utilisez ces identifiants :

Email : test@example.com

Mot de passe : password

📖 Utilisation
Se connecter avec les identifiants de test

Créer un projet via le bouton "Nouveau projet"

Ajouter des tâches en cliquant sur "Nouvelle tâche"

Assigner des tâches aux utilisateurs via le formulaire

Glisser-déposer les tâches entre les colonnes de statut