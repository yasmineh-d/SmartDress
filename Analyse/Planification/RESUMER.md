# Résumé du projet **SmartDress**

## Contexte
SmartDress est une application mobile intelligente qui aide les utilisateurs à choisir leurs tenues quotidiennes en fonction du climat, du style et de la garde‑robe digitale.

## Choix technologiques (Backend)
- **PHP 8.2 + Laravel 12** – framework MVC robuste, ORM Eloquent.
- **NativePHP Mobile** – empaquetage de Laravel en APK Android.
- **Laravel Sanctum & Laravel UI** – authentification sécurisée (sessions web + tokens API).
- **Spatie Laravel Permission** – gestion fine des rôles (admin, utilisateur).
- **MySQL** (ou SQLite en mode mobile) – SGBDR fiable, utilisé via Eloquent.

## Choix technologiques (Frontend)
- **Tailwind CSS + Preline UI** – design moderne, responsive, composants prêts à l’emploi.
- **Alpine.js** – interactions légères (modales, filtres, sélecteurs).
- **Vite 7** – build ultra‑rapide avec HMR, intégration du plugin NativePHP.

## Architecture logicielle
- **Contrôleurs** (maigres) → **Services** (logique métier) → **Eloquent** (accès aux données).
- Relations : `User` ⇄ `Vetement`, `Tenue`, `Favoris`, `Role`, `Permission`.
- **API RESTful** exposée pour le mobile, sécurisée par Sanctum.

## Base de données
- Modélisation relationnelle avec tables pivot (`tenue_vetement`, `role_user`).
- Migrations et seeders (CSV `vetements.csv`) pour peupler les données de test.

## Sécurité & performances
- HTTPS obligatoire, CSRF protection, permissions granulaire via Spatie.
- Cache des appels météo, eager‑loading et index DB pour optimiser les requêtes.

## Perspectives d’évolution
- Migration MySQL → solution cloud (Aurora, RDS).
- API GraphQL pour requêtes flexibles.
- Algorithme de recommandation avancé (style, préférences, IA).

---
Ce fichier résume la branche technique de SmartDress et servira de base pour la rédaction du rapport final.
