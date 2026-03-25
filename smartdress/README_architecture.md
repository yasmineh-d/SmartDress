# Architecture Laravel : Contrôleurs, Services et Seeders

Ce document explique la différence fondamentale entre les différentes couches de l'application **SmartDress** afin de garder un code propre, professionnel et facilement maintenable.

## 1. Les Contrôleurs (Les Aiguilleurs)
* **Emplacement :** `app/Http/Controllers/`
* **Rôle :** Ils reçoivent les requêtes HTTP (l'utilisateur valide un formulaire, clique sur un bouton), demandent au système de traiter les données, puis renvoient la réponse (une vue HTML, une redirection).
* **Règle d'or :** Un contrôleur doit être **le plus "maigre" possible**. Il ne "réfléchit" pas. Si tu commences à écrire des `if/else` complexes, des requêtes base de données avec beaucoup de filtres, ou du code d'upload (enregistrement de fichiers), **ce n'est pas sa place**.

## 2. Les Services (Les Cerveaux / La Logique Métier)
* **Emplacement :** `app/Services/`
* **Rôle :** C'est ici que vit toute l'intelligence de SmartDress (la "Business Logic"). Les services contiennent le code complexe qui fait fonctionner l'application dans la vraie vie pour les utilisateurs finaux.
* **Exemples créés :**
  * `OutfitRecommendationService` : Réfléchit à quelle tenue proposer selon la météo.
  * `WardrobeService` : Vérifie si la garde-robe de l'utilisateur contient au moins un haut, un bas et des chaussures pour être valide.
  * `ImageUploadService` : Gère le renommage, l'upload sécurisé et la suppression des photos de vêtements sur le serveur.
  * `WeatherService` : Calcule et récupère la température pour déduire si le temps est "Hiver" ou "Été".
* **Interaction :** Le contrôleur appelle une méthode simple d'un Service (ex : `$service->getBestOutfit(...)`) et lui fait confiance pour faire tout le travail compliqué en coulisses.

## 3. Les Seeders (Les Ouvriers de Chantier)
* **Emplacement :** `database/seeders/`
* **Rôle :** Les seeders sont des outils **exclusifs aux développeurs**. Ils servent *uniquement* à peupler la base de données avec de fausses informations (utilisateurs, vêtements, tenues de test) pendant la phase de création ou de test du site.
* **Faut-il créer des Services pour les Seeders ? :** **NON !**
  * Les Seeders sont déjà des classes spécialisées prévues par Laravel pour générer des données.
  * Un Service est fait pour exécuter du code lors de l'utilisation normale de l'application web. Qu'un utilisateur se connecte, l'application fonctionnera sans jamais faire appel aux Seeders. Le code de peuplement (comme lire le fichier CSV) est parfaitement à sa place dans le Seeder.

---
**En résumé :** 
1. Le **Contrôleur** reçoit la commande du client.
2. Il transmet la commande au **Service** qui "cuisine" et calcule l'algorithme.
3. Le **Seeder** lui, n'est là que la nuit quand le restaurant est fermé, pour remplir les frigos afin que tout soit prêt pour tester le lendemain matin !
