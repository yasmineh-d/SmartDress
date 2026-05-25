---
trigger: /identity
type: rule
id: smartdress-visual-identity
---

# CHARTE VISUELLE - SMARTDRESS

## Principes UI

- Interface claire et épurée, centrée sur la gestion de la garde-robe.
- Utiliser des libellés français explicites : `Garde-robe`, `Favoris`, `Tenues`, `Profil`.
- Favoriser un design responsive adapté aux pages Web et aux vues mobiles.

## Composants attendus

- Cartes de vêtements avec image, catégorie, couleur et saison.
- Boutons principaux en `btn-primary` pour les actions de création / validation.
- Notifications de succès / erreur visibles dans un bandeau fixe ou une alerte.

## Pages spécifiques

- `dashboard-web` : résumé des vêtements, nombre total, favoris et recommandations.
- `garde-robe-web` : liste des vêtements et accès au formulaire d'ajout.
- `favoris-web` : favoris de vêtements et de tenues.
- `dashboard_mobile` : interface mobile simplifiée avec navigation compacte.

## Règles d'accessibilité

- Les images doivent avoir un `alt` descriptif.
- Les éléments cliquables doivent respecter les contraste et l'espacement.
- Les formulaires doivent afficher les erreurs de validation près du champ concerné.
