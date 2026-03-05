# Sitemap : SmartDress

> **Source** : `Analyse/Cahier_des_charges/cahier_des_charges.md`  
> **Règles appliquées** : Siloing thématique, Règle des 3 clics, Menu ≤ 7 entrées.

---

## 🌐 Application Mobile — Espace Utilisateur

```
[Accueil / Splash Screen]
├── [Authentification]
│   ├── Connexion
│   └── Création de compte
│
├── [Tableau de Bord] ← Page principale post-connexion
│   └── Suggestion de tenue du jour (avec météo)
│
├── [Ma Garde-Robe]
│   ├── Liste des vêtements (filtres par catégorie, style, couleur)
│   ├── Ajouter un vêtement (photo + détails)
│   ├── Modifier un vêtement
│   └── Supprimer un vêtement
│
├── [Suggestions de Tenues]
│   ├── Tenue du jour (basée sur météo et préférences)       ← Sprint 1
│   ├── Historique des suggestions                           ← Sprint 1
│   ├── Favoris / Tenues sauvegardées                       ← Sprint 2
│   └── Partage de tenues                                   ← Sprint 2
│
├── [Statistiques Personnelles]                             ← Sprint 2
│   ├── Vêtements les plus portés
│   └── Historique d'utilisation
│
└── [Profil & Paramètres]
    ├── Informations personnelles
    ├── Préférences de style
    └── Notifications (activation/désactivation)
```

---

## 🔐 Espace Administrateur

```
[Connexion Admin]
│
└── [Tableau de Bord Admin]
    ├── [Gestion des Utilisateurs]                          ← Sprint 1
    │   ├── Liste des utilisateurs
    │   └── Activation / Désactivation de compte
    │
    ├── [Statistiques Globales]                             ← Sprint 1
    │   └── Vue d'ensemble d'utilisation
    │
    ├── [Monitoring & Performances]                         ← Sprint 2
    │   └── Performances de l'application
    │
    └── [Rapports]                                          ← Sprint 2
        └── Rapports d'utilisation et d'engagement
```

---

## 📌 Notes d'Architecture

| Règle             | Application                                                    |
|-------------------|----------------------------------------------------------------|
| Règle des 3 clics | Toute page accessible en max 3 taps depuis le Tableau de Bord |
| Siloing           | Garde-Robe / Suggestions / Stats = 3 silos distincts          |
| Menu principal    | 5 entrées : Tableau de Bord, Garde-Robe, Suggestions, Stats, Profil |
| Sprint tagging    | Chaque page est taguée Sprint 1 ou Sprint 2 pour priorisation |
