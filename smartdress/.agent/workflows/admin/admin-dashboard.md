---
description: Construction du tableau de bord administrateur SmartDress.
trigger: /admin-dashboard
---

# 🧑‍💼 WORKFLOW : ADMIN DASHBOARD

## Commande déclencheuse
`/admin-dashboard`

## Objectif
Créer ou vérifier le tableau de bord admin dans `AdminController` et la vue `pages.admin.admin-dashboard`.

## Étapes d'exécution

1. Récupérer la liste des utilisateurs et leurs rôles depuis `User::with('roles')`.
2. Calculer le nombre total d'utilisateurs.
3. Préparer une collection d'activités récentes.
4. Afficher une table d'utilisateurs dans la vue.

## Checklist
- [ ] Le dashboard affiche `totalUsers`.
- [ ] Chaque utilisateur a son rôle affiché.
- [ ] Les activités sont présentes sous forme de liste.
- [ ] Seules les personnes avec le rôle `admin` accèdent au dashboard.
