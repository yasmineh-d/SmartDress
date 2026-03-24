# Plan d'Implémentation : Seeders et Données CSV

L'objectif est de peupler la base de données avec des données de test réalistes pour faciliter le développement et les démonstrations du projet **SmartDress**.

## Proposed Changes

### Données de Test (CSV)
- **[NEW] `database/data/vetements.csv`** : Création d'un fichier CSV contenant une liste de vêtements variés (Hauts, Bas, Chaussures) avec leurs attributs (catégorie, saison, style).

### Seeders Laravel
Je vais créer plusieurs seeders pour organiser les données :

#### [MODIFY] `database/seeders/DatabaseSeeder.php`
- Appeler les nouveaux seeders dans l'ordre de dépendance.

#### [NEW] `database/seeders/RolePermissionSeeder.php`
- Créer les rôles `admin` et `utilisateur`.
- Créer des permissions de base.

#### [NEW] `database/seeders/UserSeeder.php`
- Créer un compte administrateur et un compte utilisateur de test.

#### [NEW] `database/seeders/VetementSeeder.php`
- Lire le fichier `vetements.csv`.
- Insérer les vêtements pour les utilisateurs de test.

#### [NEW] `database/seeders/TenueSeeder.php`
- Créer quelques tenues de test en liant des vêtements via la table pivot.

---

## Verification Plan

### Automated Tests
- Exécuter `php artisan db:seed`.
- Vérifier le nombre d'enregistrements via `php artisan db:show` ou via Tinker.

### Manual Verification
- Vérifier que les relations (pivot table `tenue_vetement`) sont correctement peuplées via une requête simple.
