# Explication des Tests de Services SmartDress

En plus des services eux-mêmes, nous avons écrit un fichier de **Test Unitaire (Unit Test)** pour chacun d'entre eux.

## 1. À quoi servent ces tests ?
Les tests sont tes **filets de sécurité tactiques**. Demain, si tu fais une petite modification dans ton code (par exemple, si tu changes le seuil de température de l'hiver de 15°C à 10°C), tu risques sans le savoir de casser ton application. Au lieu de lancer ton site web et de cliquer partout pour vérifier que tout marche, tu lances la commande `php artisan test`. Laravel va vérifier chaque scénario de test en **moins de 5 secondes**.

## 2. Ce que font nos Tests actuellement

### 🧪 `OutfitRecommendationServiceTest`
* **Scénario "Chaud"** : Simule 25°C et vérifie que le service renvoie bien le look "Été".
* **Scénario "Froid"** : Simule 5°C et vérifie que le service renvoie bien le look "Hiver".
* **Scénario "Vide"** : Simule un utilisateur sans garde-robe et vérifie que ça ne fait pas planter l'application (ça renvoie proprement `null`).

### 🧪 `WeatherServiceTest`
* **Scénario "Mock API"** : Vérifie que le service renvoie bien 12.5°C pour "Paris" sans jamais appeler la vraie météo (ce qui t'économise du temps et de l'argent sur une vraie API).
* **Scénario "Saison"** : Donne une température de -5°C à la fonction et s'assure qu'elle renvoie le mot "Hiver", et inversement pour l'été.

### 🧪 `WardrobeServiceTest`
* **Scénario "Garde-robe Complète"** : Simule la création (en base de données éphémère) d'un Haut, d'un Bas et de Chaussures pour un utilisateur. Vérifie que la fonction `hasEnoughClothesForOutfit()` donne le feu vert (`true`).
* **Scénario "Garde-robe Incomplète"** : Simule seulement un Haut et un Bas. La fonction vérifie s'il manque des Chaussures et stoppe gentiment le processus (`false`), pour éviter que l'IA ne génère une tenue avec un utilisateur pieds nus !

### 🧪 `ImageUploadServiceTest`
* **Scénario "Upload Sécurisé"** : Au lieu d'écrire une vraie image dans ton dossier (ce qui remplirait ton ordinateur de fausses photos), Laravel utilise `Storage::fake('public')`. Il trompe le service, lui fait croire qu'il a téléchargé l'image, et teste si le système l'a bien reconnue.
* **Scénario "Image Manquante"** : S'assure que si l'utilisateur essaie de télécharger le formulaire "à vide", le service s'en rend compte et renvoie `null` au lieu de créer un bug "Fatal Error".

---

**La commande magique :**
À chaque fois que tu vas coder une nouvelle fonctionnalité dans le futur, pense bien à taper `php artisan test` dans le terminal avant. Si ça clignote en vert, c'est bon pour la production ! ✅
