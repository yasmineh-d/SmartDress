# Explication des 4 Services de SmartDress

Voici le détail de chaque service ("cerveau" de l'application) que nous avons mis en place ensemble, et à quoi il va te servir quand tu vas coder l'affichage de ton site.

## 1. `OutfitRecommendationService` (Le Styliste)
*   **Fichier :** `app/Services/OutfitRecommendationService.php`
*   **Son Rôle :** C'est le cœur de SmartDress. Au lieu que ton contrôleur se casse la tête à chercher "Quelle tenue je dois choisir ?", ce service s'en charge.
*   **Sa Méthode (Fonction) :** `getBestOutfit(User $user, float $temperature)`
*   **Comment ça marche :** Tu lui donnes un utilisateur et la température extérieure. Si la température est >= 15°C, il va fouiller dans la base de données et trouver la première tenue de cet utilisateur qui contient le mot "Été". Sinon, il cherche "Hiver".

## 2. `WeatherService` (Le Météorologue)
*   **Fichier :** `app/Services/WeatherService.php`
*   **Son Rôle :** Récupérer et analyser la météo. 
*   **Ses Méthodes :** 
    *   `getCurrentTemperature($ville)` : Pour l'instant on a simulé quelques villes (Paris = 12.5°C, Marseille = 26°C), mais plus tard, c'est ici que tu mettras le code pour te connecter à une vraie API météo (comme OpenWeather).
    *   `getWeatherCondition($temperature)` : Tu lui donnes une température, et il te répond si c'est "Hiver" (moins de 15°C) ou "Été".

## 3. `WardrobeService` (Le Gestionnaire de Garde-Robe)
*   **Fichier :** `app/Services/WardrobeService.php`
*   **Son Rôle :** Faire des vérifications mathématiques ou complexes sur les vêtements que possède un utilisateur.
*   **Sa Méthode Clé :** `hasEnoughClothesForOutfit(User $user)`
*   **Comment ça marche :** Avant de proposer de créer une tenue, il vérifie si l'utilisateur possède bien dans sa base de données **au moins 1 Haut, 1 Bas et 1 paire de Chaussures**. Si c'est "vrai" (true), tu pourras lui afficher le bouton "Créer une tenue". Si c'est "faux" (false), tu pourras lui afficher "Veuillez d'abord ajouter plus de vêtements".

## 4. `ImageUploadService` (Le Photographe)
*   **Fichier :** `app/Services/ImageUploadService.php`
*   **Son Rôle :** Gérer tout ce qui touche aux fichiers images pour ne pas alourdir ton `VetementController`.
*   **Ses Méthodes :**
    *   `uploadClothingImage($image)` : Dès qu'un utilisateur enverra une photo d'un t-shirt depuis ton formulaire HTML, tu passeras l'image à cette fonction. Elle génère un nom totalement unique (ex: `17009841_AzeRty12.jpg`) pour éviter d'écraser des fichiers ayant le même nom, et l'enregistre sur ton serveur (`storage/app/public/clothes`).
    *   `deleteImage($chemin)` : Permet d'effacer proprement la photo du serveur quand l'utilisateur supprime son vêtement.

---

**Comment les utiliser demain ?**
Dans ton contrôleur (ex: `VetementController`), au lieu d'écrire 50 lignes, tu auras simplement besoin de "brancher" ton service au dessus, et de lui parler en une ligne :

```php
// Exemple d'utilisation dans le contrôleur :
$cheminImage = $this->imageService->uploadClothingImage($request->file('photo'));
```
