# Backlog d'Issues GitHub – SmartDress

Ce document regroupe toutes les **issues GitHub** prêtes à être créées pour votre projet **SmartDress**, réparties par **Sprint 1 (MVP)** et **Sprint 2 (Améliorations & Recommandations Avancées)**. Chaque ticket inclut le statut réel tiré de votre projet, les labels suggérés, une description au format User Story, des critères d'acceptation et des tâches associées.

---

## 🏃 Sprint 1 : Fondations et MVP (Minimum Viable Product)

### Issue #1 : [User Story] Authentification et Connexion sécurisée
* **Statut :** `En cours 🛠️` *(La connexion/déconnexion et la redirection par rôle sont opérationnelles ; reste à concevoir l'inscription d'utilisateurs)*
* **Type :** Feature / User Story
* **Priorité :** `High`
* **Labels :** `sprint-1`, `backend`, `frontend`, `security`

#### Description
> En tant qu'utilisateur, je veux pouvoir créer un compte et m'authentifier de manière sécurisée afin d'accéder à mon espace personnel et de sauvegarder ma garde-robe.

#### Critères d'acceptation
- [x] Un utilisateur enregistré peut se connecter et maintenir sa session.
- [x] Un utilisateur connecté peut se déconnecter proprement.
- [x] Accès restreint aux pages privées via un middleware d'authentification (`auth`).
- [ ] Un visiteur peut s'inscrire de manière autonome avec un formulaire d'inscription (Nom, Email, Mot de passe).
- [ ] Les mots de passe créés lors de l'inscription sont hashés en base de données.

#### Tâches
- [x] Implémenter les méthodes d'authentification (`login`/`logout`) dans `AuthController.php`.
- [x] Sécuriser les routes privées dans `web.php` avec le middleware `auth`.
- [ ] Créer le formulaire et la route d'inscription d'utilisateurs.
- [ ] Ajouter la validation des données d'inscription (email unique, mot de passe requis).

---

### Issue #2 : [User Story] Gestion des vêtements (CRUD Garde-robe)
* **Statut :** `Terminé ✅` *(Le contrôleur, le modèle, la table pivot et les vues sont entièrement implémentés et testés)*
* **Type :** Feature / User Story
* **Priorité :** `High`
* **Labels :** `sprint-1`, `backend`, `database`

#### Description
> En tant qu'utilisateur, je veux ajouter, modifier et supprimer des vêtements de ma garde-robe digitale afin de tenir mon dressing virtuel à jour.

#### Critères d'acceptation
- [x] Possibilité d'ajouter un vêtement avec un nom, une catégorie (haut, bas, chaussures), un style et une couleur.
- [x] Possibilité d'éditer les informations d'un vêtement existant.
- [x] Possibilité de supprimer définitivement un vêtement de la garde-robe.
- [x] Affichage de la liste de tous les vêtements de l'utilisateur avec pagination ou filtres simples.

#### Tâches
- [x] Créer la migration et le modèle `Vetement`.
- [x] Implémenter le contrôleur `VetementController.php`.
- [x] Concevoir la vue Blade de la liste des vêtements (`garde-robe-web.blade.php`).
- [x] Configurer les formulaires d'ajout et de modification avec validation des données.

---

### Issue #3 : [User Story] Téléversement et gestion des photos de vêtements
* **Statut :** `Terminé ✅` *(L'upload de photos de vêtements et leur suppression automatique sur le stockage disque sont implémentés dans VetementController ; de plus, ImageUploadService est prêt et testé)*
* **Type :** Feature / User Story
* **Priorité :** `High`
* **Labels :** `sprint-1`, `backend`, `media`

#### Description
> En tant qu'utilisateur, je veux associer une photo à mes vêtements lors de l'ajout pour pouvoir visualiser concrètement ma garde-robe.

#### Critères d'acceptation
- [x] L'utilisateur peut uploader une photo au format standard (JPG, PNG, WebP).
- [x] Le fichier est stocké de manière sécurisée.
- [x] La photo s'affiche correctement sur la fiche du vêtement.
- [x] Supprimer un vêtement supprime également sa photo physique sur le disque pour éviter de surcharger le stockage.

#### Tâches
- [x] Implémenter l'upload dans `VetementController.php`.
- [x] Créer le service réutilisable `ImageUploadService.php` avec ses tests unitaires.
- [x] Configurer le stockage publique via `php artisan storage:link`.

---

### Issue #4 : [User Story] Recommandation de tenue simple selon la saison météo
* **Statut :** `Terminé ✅` *(OutfitRecommendationService et WardrobeService sont programmés, testés à 100% et intégrés au tableau de bord)*
* **Type :** Feature / User Story
* **Priorité :** `High`
* **Labels :** `sprint-1`, `backend`, `algorithm`

#### Description
> En tant qu'utilisateur, je veux recevoir une suggestion de tenue quotidienne basée sur la saison météo simplifiée afin de ne plus perdre de temps à choisir mes vêtements le matin.

#### Critères d'acceptation
- [x] Le système détermine si la température est "Chaude" (>= 15°C) ou "Froide" (< 15°C).
- [x] Le système suggère un look d'Été si le temps est chaud et un look d'Hiver si le temps est froid.
- [x] Si la garde-robe est incomplète, renvoyer une alerte élégante demandant à l'utilisateur d'ajouter au moins 1 Haut, 1 Bas et 1 paire de Chaussures.

#### Tâches
- [x] Mettre en place la logique de décision dans `OutfitRecommendationService.php`.
- [x] Utiliser `WardrobeService.php` pour la vérification des pièces de vêtements minimales.
- [x] Afficher la recommandation de look sur la vue `dashboard-web.blade.php`.

---

### Issue #5 : [User Story] Tableau de bord d'administration de base
* **Statut :** `Terminé ✅` *(AdminController et AdminDashboardService sont écrits et branchés avec des statistiques au niveau du tableau de bord admin)*
* **Type :** Feature / User Story
* **Priorité :** `Medium`
* **Labels :** `sprint-1`, `admin-panel`, `dashboard`

#### Description
> En tant qu'administrateur, je veux me connecter à un espace réservé pour voir l'état général et les statistiques clés de l'application SmartDress.

#### Critères d'acceptation
- [x] Connexion sécurisée avec restriction par rôle `admin`.
- [x] Affichage du nombre total d'utilisateurs inscrits.
- [x] Affichage du nombre total de vêtements numérisés sur la plateforme.
- [x] Affichage de la moyenne de vêtements possédés par utilisateur.

#### Tâches
- [x] Implémenter la logique de comptage statistique dans `AdminDashboardService.php`.
- [x] Configurer la route `/admin` gérée par `AdminController.php`.
- [x] Créer la vue d'administration `admin-dashboard.blade.php`.

---

### Issue #6 : [DevOps] Peuplement de la base de données (Seeders & CSV)
* **Statut :** `Terminé ✅` *(Tous les seeders sont entièrement fonctionnels, lisent le CSV et créent les rôles, permissions, comptes de test et tenues)*
* **Type :** Task / Chore
* **Priorité :** `Medium`
* **Labels :** `sprint-1`, `database`, `devops`

#### Description
> Automatiser la création de données de test cohérentes (rôles, permissions, comptes utilisateurs, vêtements fictifs à partir d'un fichier CSV) pour faciliter le développement local.

#### Critères d'acceptation
- [x] La commande `php artisan db:seed` s'exécute sans erreur.
- [x] Création automatique des rôles `admin` et `utilisateur` ainsi que de leurs permissions associées.
- [x] Chargement et insertion des vêtements à partir de `vetements.csv`.
- [x] Création de tenues d'exemple associées à des vêtements pour l'utilisateur de test.

#### Tâches
- [x] Configurer l'ordre des appels dans `DatabaseSeeder.php`.
- [x] Créer `RolePermissionSeeder.php`, `UserSeeder.php` et `VetementSeeder.php`.
- [x] Écrire `TenueSeeder.php` pour relier des vêtements à des looks par défaut.

---

## 🚀 Sprint 2 : Améliorations et Recommandations Avancées

### Issue #7 : [User Story] Intégration de l'API météo en temps réel (OpenWeatherMap)
* **Statut :** `À faire ⏳` *(Le système utilise actuellement un simulateur switch/case en dur dans WeatherService)*
* **Type :** Feature / User Story
* **Priorité :** `High`
* **Labels :** `sprint-2`, `backend`, `api-integration`

#### Description
> En tant qu'utilisateur, je veux que la recommandation de mes tenues s'adapte à la météo réelle de ma ville actuelle (et non pas sur des valeurs simulées en dur) afin de sortir habillé de façon adaptée.

#### Critères d'acceptation
- [ ] L'application appelle une API externe de météo (ex : OpenWeatherMap API) en transmettant la ville de l'utilisateur.
- [ ] Enregistrement et mise en cache des appels météo pour optimiser les performances et éviter de saturer les quotas d'API.
- [ ] Gestion des cas de panne ou hors-ligne (fallback sur une valeur par défaut).

#### Tâches
- [ ] Obtenir et configurer les clés API dans le fichier `.env`.
- [ ] Implémenter l'appel HTTP dans `WeatherService.php` en utilisant le client HTTP de Laravel.
- [ ] Rédiger des tests unitaires mockés pour simuler le comportement de l'API externe sans faire d'appels réels.

---

### Issue #8 : [User Story] Algorithme de recommandation avancé (Style & Préférences)
* **Statut :** `À faire ⏳` *(L'algorithme de suggestion n'utilise que la température pour le moment)*
* **Type :** Feature / User Story
* **Priorité :** `High`
* **Labels :** `sprint-2`, `backend`, `algorithm`

#### Description
> En tant qu'utilisateur, je veux des recommandations de tenues basées non seulement sur la température mais aussi sur mon style préféré du jour (casual, chic, sportswear) pour refléter mon humeur et mon look.

#### Critères d'acceptation
- [ ] L'utilisateur peut sélectionner un style ou une humeur sur son tableau de bord.
- [ ] L'algorithme filtre en priorité les vêtements qui correspondent à la fois à la météo ET au style sélectionné.
- [ ] Intégration d'un système de notation ou de retour de l'utilisateur pour affiner les prochaines propositions.

#### Tâches
- [ ] Modifier la méthode `getBestOutfit()` de `OutfitRecommendationService.php` pour accepter un paramètre optionnel `$style`.
- [ ] Mettre à jour l'interface utilisateur pour intégrer la sélection de style avant recommandation.
- [ ] Rédiger les tests correspondants.

---

### Issue #9 : [User Story] Ajout et gestion de listes de tenues favorites
* **Statut :** `Terminé ✅` *(FavorisController, FavorisApiController, la table favoris et favoris-web.blade.php sont déjà implémentés et opérationnels)*
* **Type :** Feature / User Story
* **Priorité :** `Medium`
* **Labels :** `sprint-2`, `frontend`, `backend`

#### Description
> En tant qu'utilisateur, je veux sauvegarder les combinaisons de tenues recommandées ou personnalisées que j'aime le plus dans une section "Favoris" pour pouvoir les réutiliser rapidement.

#### Critères d'acceptation
- [x] L'utilisateur peut cliquer sur une icône de cœur ou un bouton "Ajouter aux favoris".
- [x] Une page dédiée répertorie l'ensemble des tenues favorites sauvegardées.
- [x] Possibilité de supprimer une tenue de ses favoris à tout moment.

#### Tâches
- [x] Implémenter l'API de gestion des favoris dans `FavorisApiController.php`.
- [x] Concevoir le contrôleur `FavorisController.php` et sa vue `favoris-web.blade.php`.
- [x] Intégrer les requêtes de favoris.

---

### Issue #10 : [User Story] Statistiques personnelles d'utilisation (Vêtements les plus portés)
* **Statut :** `À faire ⏳`
* **Type :** Feature / User Story
* **Priorité :** `Low`
* **Labels :** `sprint-2`, `frontend`, `charts`

#### Description
> En tant qu'utilisateur, je veux voir des graphiques et des statistiques sur ma garde-robe (par exemple, mes vêtements les plus portés, ou la répartition par couleur/style) afin de mieux planifier mes achats futurs.

#### Critères d'acceptation
- [ ] Calcul automatique des statistiques sur les vêtements sélectionnés dans les tenues portées.
- [ ] Affichage d'un graphique (ex. camembert ou diagramme en barres) représentant la répartition par couleur ou catégorie.
- [ ] Liste des "Top 3 vêtements les plus souvent portés".

#### Tâches
- [ ] Configurer une table de journalisation (historique de tenues portées par jour).
- [ ] Créer un service de statistiques personnelles pour regrouper les calculs.
- [ ] Intégrer une librairie de graphiques simple (ex: Chart.js) sur l'interface du profil utilisateur.

---

### Issue #11 : [User Story] Tableau de bord d'administration avancé et Monitoring
* **Statut :** `À faire ⏳`
* **Type :** Feature / User Story
* **Priorité :** `Medium`
* **Labels :** `sprint-2`, `admin-panel`, `monitoring`

#### Description
> En tant qu'administrateur, je veux accéder à des rapports avancés d'engagement utilisateur et surveiller les performances de l'application (erreurs API, temps de réponse) pour assurer un service de qualité.

#### Critères d'acceptation
- [ ] Un graphique d'évolution des inscriptions d'utilisateurs au fil du temps.
- [ ] Section affichant les taux de complétion de garde-robe par les inscrits.
- [ ] Une interface simple listant les alertes de requêtes en échec (logs d'erreurs).

#### Tâches
- [ ] Étendre le `AdminController.php` pour fournir des données d'évolution par date.
- [ ] Intégrer des visualisations graphiques avancées pour l'administration.
- [ ] Mettre en place un journal d'erreurs filtrable dans l'interface admin.
