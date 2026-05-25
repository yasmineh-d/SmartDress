---
description: Gestion de la garde-robe, des vêtements et des favoris.
trigger: /user-wardrobe
---

# 👗 WORKFLOW : GARDE-ROBE UTILISATEUR

## Commande déclencheuse
`/user-wardrobe`

## Objectif
Valider la gestion de la garde-robe dans `VetementController`, la vue `garde-robe-web` et la relation vers `Favoris`.

## Étapes d'exécution

1. Afficher la liste des vêtements de l'utilisateur avec leurs photos.
2. Permettre la création d'un vêtement via un formulaire.
3. Gérer l'upload de photo et la création d'un enregistrement `Photo` lié.
4. Supprimer proprement les photos et le vêtement lors de la suppression.
5. Afficher les favoris et indiquer ceux qui sont déjà ajoutés.

## Checklist
- [ ] La vue `garde-robe` affiche les vêtements filtrés par l'utilisateur.
- [ ] L'ajout de vêtement stocke correctement la photo.
- [ ] La suppression supprime aussi les fichiers de stockage.
- [ ] Les favoris sont récupérés et affichés.
