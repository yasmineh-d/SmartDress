# SmartDress Agent Configuration

Ce dossier `.agent` contient la configuration de l'agent dédié au projet **SmartDress**. Il est conçu pour guider le développement, la maintenance et l'évolution du code Laravel/Web/Mobile du projet.

## Structure du dossier

```
.agent/
├── README.md
├── rules/
│   ├── system/
│   │   └── master_instructions.md
│   ├── data/
│   │   └── service_layer.md
│   ├── roles/
│   │   └── access_control.md
│   └── visual/
│       └── identity.md
├── skills/
│   ├── smartdress-architect/
│   │   └── SKILL.md
│   ├── smartdress-builder/
│   │   └── SKILL.md
│   └── smartdress-developer/
│       └── SKILL.md
└── workflows/
    ├── shared/
    │   ├── installation.md
    │   └── authentification.md
    ├── admin/
    │   └── admin-dashboard.md
    └── user/
        ├── wardrobe.md
        └── outfit-recommendation.md
```

## Commandes rapides de l'agent

| Commande | Description |
|---|---|
| `/install-smartdress` | Installer les dépendances, configurer Laravel et préparer l'environnement de développement |
| `/auth-flow` | Valider l'authentification, la redirection du dashboard et les protections utilisateur |
| `/admin-dashboard` | Construire le tableau de bord administrateur et la gestion des utilisateurs |
| `/user-wardrobe` | Gérer la garde-robe, l'ajout de vêtements et les favoris |
| `/user-outfit` | Implémenter la recommandation de tenue, le service météo et l'expérience mobile |

## Objectif

L'agent SmartDress doit aider à:

- conserver le code propre entre contrôleurs, services et vues
- respecter la logique métier du projet
- fiabiliser le stockage des images et l'upload
- garantir une expérience utilisateured cohérente entre Web et Mobile
- documenter clairement les conventions du projet
