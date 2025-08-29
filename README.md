# TaskManager - Application de Gestion de Projets et Tâches

Application full-stack développée avec Laravel 10+ et Vue.js 3 pour la gestion de projets et tâches.

## Fonctionnalités

- ✅ Authentification utilisateur (register/login/logout)
- ✅ CRUD complet pour les projets
- ✅ CRUD complet pour les tâches
- ✅ Assignation de tâches aux utilisateurs
- ✅ Système de drag & drop pour changer le statut des tâches
- ✅ Notifications par email pour les tâches assignées
- ✅ Interface responsive avec Tailwind CSS
- ✅ Gestion d'état avec Pinia
- ✅ Validation des formulaires
- ✅ Tests unitaires et fonctionnels

## Technologies utilisées

### Backend
- Laravel 10+
- Laravel Sanctum pour l'authentification API
- SQLite
- File-based queues
- SMTP pour les emails

### Frontend
- Vue.js 3 avec Composition API
- Vue Router pour la navigation
- Pinia pour la gestion d'état
- Axios pour les requêtes HTTP
- Tailwind CSS pour le styling
- HTML5 Drag & Drop API

## Installation

### Prérequis
- PHP 8.1+
- Composer
- Node.js 16+
- SQLite 3.13
- Git

### Backend (Laravel)

1. Cloner le repository
   ```bash
   git clone <repository-url>
   cd backend-laravel