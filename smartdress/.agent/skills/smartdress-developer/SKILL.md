---
name: smartdress-developer
description: Intégration front-end, Blade templates et expérience utilisateur pour SmartDress.
---

# 🎨 COMPÉTENCE : SMARTDRESS DEVELOPER

## Rôle et domaine d'action
Cette compétence gère l'interface utilisateur et l'expérience SmartDress, côté Web et mobile.

## Pages principales

- `dashboard-web` : Présentation du nombre de vêtements, favoris et recommandations de tenues.
- `garde-robe-web` : Liste des vêtements, contrôles de suppression, et bouton d'ajout.
- `favoris-web` : Vue des favoris associés aux vêtements et aux tenues.
- `dashboard_mobile` : Version simplifiée pour l'utilisation mobile.
- `profile-web` et `edit-profile-web` : pages de gestion du compte utilisateur.

## Composants interactifs

- Notifications Toast pour chaque action d'ajout, modification ou suppression.
- Formulaires avec validation explicite des champs.
- Cartes de vêtements avec image, catégorie, saison et style.
- Interfaces responsive pour les vues mobiles.

## Règles de rendu

- Toujours afficher les erreurs de validation à proximité du champ concerné.
- Chaque image doit avoir un `alt` clair.
- Les actions critiques (suppression) doivent demander confirmation si possible.
- Ne pas charger des données inutiles : utiliser `with('photos')` pour les relations image seulement quand nécessaire.

## Exemple de Toast

```html
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
     class="fixed bottom-4 right-4 z-50 px-4 py-3 bg-emerald-50 text-emerald-900 rounded-lg shadow">
  <p>Action effectuée avec succès !</p>
</div>
```
