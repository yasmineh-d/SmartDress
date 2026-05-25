---
description: Installation et configuration initiale du projet SmartDress.
trigger: /install-smartdress
---

# ⚙️ WORKFLOW : INSTALLATION SMARTDRESS

## Commande déclencheuse
`/install-smartdress`

## Étapes d'exécution

1. Vérifier que les dépendances sont installées : `composer install` et `npm install` si nécessaire.
2. Créer le fichier d'environnement : `cp .env.example .env`.
3. Générer la clé d'application : `php artisan key:generate`.
4. Vérifier les variables de base de données et les clés API nécessaires.
5. Lancer les migrations : `php artisan migrate`.
6. Exécuter les seeders de test si besoin : `php artisan db:seed`.
7. Créer le lien de stockage public : `php artisan storage:link`.

## Checklist
- [ ] Le projet se lance sans erreur sur `php artisan serve`.
- [ ] La base de données contient les tables attendues (`users`, `vetements`, `tenues`, `favoris`, `photos`).
- [ ] Les fichiers uploadés sont accessibles via `storage/app/public`.
- [ ] La page d'accueil `/` fonctionne.
