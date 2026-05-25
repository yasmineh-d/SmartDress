---
trigger: always_on
type: rule
id: smartdress-master-instructions
---

# DIRECTIVES MAÎTRESSES - SMARTDRESS

## Architecture du projet

1. **Couche contrôleurs / services / vues**
   - Les contrôleurs de `app/Http/Controllers/` doivent rester minces.
   - Toute logique métier complexe appartient aux services de `app/Services/`.
   - Les formulaires sont validés via `Request` ou `$request->validate()` dans le contrôleur, puis transmis aux services.

2. **Gestion des données**
   - Utiliser exclusivement Eloquent pour les opérations de lecture et de modification de données.
   - Éviter les requêtes SQL brutes sauf pour des cas très spécifiques clairement justifiés.
   - Les relations doivent être explicites (`hasMany`, `belongsTo`, `belongsToMany`).

3. **Sécurité et stockage**
   - Les uploads d'images doivent utiliser `Storage::disk('public')` et conserver des chemins sécurisés.
   - Supprimer les fichiers physiques associés lors de la suppression de l'entité correspondante.
   - Ne jamais exposer de données sensibles dans les vues ou les réponses JSON.

4. **Langue et conventions**
   - Toute la documentation, les messages d'erreur, les variables métier et les commentaires doivent être en **Français**.
   - Préférer des noms clairs comme `garde-robe`, `tenue`, `vetement`, `favoris`, `utilisateur`.

5. **UX Web / Mobile**
   - Le projet propose une interface Web et des pages mobiles. Toute modification côté UI doit être testée sur les deux formats.
   - Les retours d'actions CUD doivent afficher un message de succès ou d'erreur.

6. **Conformité au projet**
   - S'appuyer sur les services existants : `OutfitRecommendationService`, `WardrobeService`, `ImageUploadService`, `VetementService`, `AdminDashboardService`.
   - Ne pas dupliquer la logique métier dans les contrôleurs si elle existe déjà dans un service.
