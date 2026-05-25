---
description: Validation de l'authentification et des redirections utilisateur.
trigger: /auth-flow
---

# 🔐 WORKFLOW : AUTHENTIFICATION

## Commande déclencheuse
`/auth-flow`

## Étapes d'exécution

### 1. Vérifier le login
- Le contrôleur `AuthController` doit valider l'email et le mot de passe.
- La méthode `login` doit rediriger vers `/dashboard` en cas de succès.

### 2. Protection des routes
- Les routes `/dashboard`, `/garde-robe`, `/favoris`, `/profil` et `/changer-mot-de-passe` doivent être protégées par le middleware `auth`.
- Le middleware doit empêcher l'accès aux utilisateurs non authentifiés.

### 3. Logout
- Le logout doit supprimer la session et rediriger vers la page de connexion.

## Checklist
- [ ] Formulaire de connexion valide et renvoie un message d'erreur en cas d'échec.
- [ ] Les pages privées sont inaccessibles sans authentification.
- [ ] Le logout fonctionne et détruit la session utilisateur.
