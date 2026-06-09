# 📱 Plan de Portage - SmartDress Mobile

Ce document détaille les étapes nécessaires pour porter et synchroniser toutes les fonctionnalités et corrections implémentées dans le projet Web principal vers l'application mobile NativePHP **SmartDress_Mobile**.

---

## 🛠️ Architecture Mobile (Client API)
L'application mobile **SmartDress_Mobile** fait office de client pour l'API du serveur principal (`http://10.0.2.2:8000` sous l'émulateur Android). Elle n'utilise pas de base de données locale complexe, mais communique avec l'application web principale.

Voici les 5 grandes étapes de développement pour finaliser le projet mobile.

---

## 📅 Étape 1 : Ajout des Saisons dans le formulaire d'ajout mobile
Dans l'application Web, nous avons normalisé la base de données pour associer les vêtements aux saisons via une table pivot Many-to-Many (`saison_vetement`). Pour permettre la création de vêtements fonctionnels depuis le mobile :

1. Ouvrez [layouts/mobile.blade.php](file:///c:/GitHub/SmartDress/SmartDress_Mobile/resources/views/layouts/mobile.blade.php).
2. Localisez le formulaire d'ajout (`#modal-add`, autour de la ligne 166).
3. Ajoutez des cases à cocher (checkboxes) pour les saisons adaptées (Hiver, Printemps, Été, Automne), limitées à 2 choix maximum (identique au web).
4. Exemple de code HTML à insérer :
```html
<div class="space-y-2">
    <label class="px-2 text-[10px] font-bold text-tan uppercase tracking-widest block">Saisons (Max 2)</label>
    <div class="grid grid-cols-2 gap-2 text-xs">
        <label class="flex items-center gap-2 bg-cream/20 p-2.5 rounded-xl border border-tan/10 cursor-pointer">
            <input type="checkbox" name="saison[]" value="printemps" class="saison-checkbox rounded text-moss focus:ring-moss border-tan/30 size-4">
            <span>Printemps</span>
        </label>
        <label class="flex items-center gap-2 bg-cream/20 p-2.5 rounded-xl border border-tan/10 cursor-pointer">
            <input type="checkbox" name="saison[]" value="ete" class="saison-checkbox rounded text-moss focus:ring-moss border-tan/30 size-4">
            <span>Été</span>
        </label>
        <label class="flex items-center gap-2 bg-cream/20 p-2.5 rounded-xl border border-tan/10 cursor-pointer">
            <input type="checkbox" name="saison[]" value="automne" class="saison-checkbox rounded text-moss focus:ring-moss border-tan/30 size-4">
            <span>Automne</span>
        </label>
        <label class="flex items-center gap-2 bg-cream/20 p-2.5 rounded-xl border border-tan/10 cursor-pointer">
            <input type="checkbox" name="saison[]" value="hiver" class="saison-checkbox rounded text-moss focus:ring-moss border-tan/30 size-4">
            <span>Hiver</span>
        </label>
    </div>
</div>
```
5. Ajoutez le script de validation dans `layouts/mobile.blade.php` pour limiter le choix à 2 saisons et envoyer les données en format Multipart (`FormData`) via une requête API `POST` vers `http://10.0.2.2:8000/api/vetements`.

---

## 🔒 Étape 2 : Implémenter l'Authentification (Laravel Sanctum) et la Protection des Routes
Pour éviter que les vêtements et favoris ne soient visibles publiquement par tout le monde, et pour rattacher chaque action au bon utilisateur connecté, nous devons sécuriser l'API et le client mobile.

### 1. Côté Serveur (Projet Web Principal) :
- Protégez les routes API de `routes/api.php` avec le middleware `auth:sanctum` :
  ```php
  Route::middleware('auth:sanctum')->group(function () {
      Route::get('/vetements', [VetementApiController::class, 'index']);
      Route::post('/vetements', [VetementApiController::class, 'store']);
      // Idem pour tenues et favoris...
  });
  ```
- Dans les contrôleurs API (ex: `VetementApiController`), filtrez les résultats par rapport à l'utilisateur connecté :
  ```php
  $user = $request->user();
  return response()->json([
      'success' => true,
      'data' => $user->vetements()->with('photos')->get()
  ]);
  ```
- Créez une route de connexion API `POST /api/login` dans `routes/api.php` qui valide les identifiants et génère un token Sanctum :
  ```php
  if (Auth::attempt($credentials)) {
      $token = $request->user()->createToken('mobile-token')->plainTextToken;
      return response()->json(['token' => $token]);
  }
  ```

### 2. Côté Mobile (Client NativePHP) :
- Implémentez un écran de connexion (Login) si aucun token n'est stocké en local.
- Lors d'une connexion réussie, enregistrez le token d'accès dans le `localStorage` de l'application mobile :
  ```javascript
  localStorage.setItem('auth_token', data.token);
  ```
- Modifiez tous les appels `fetch` de l'application mobile (`dashboard.blade.php`, `wardrobe.blade.php`, etc.) pour inclure l'en-tête de sécurité avec le Token :
  ```javascript
  const res = await fetch('http://10.0.2.2:8000/api/vetements', {
      headers: {
          'Authorization': 'Bearer ' + localStorage.getItem('auth_token'),
          'Accept': 'application/json'
      }
  });
  ```

---

## ⭐ Étape 3 : Rendre la page Favoris dynamique avec Alpine.js
Actuellement, la vue `favorites.blade.php` mobile est statique. Il faut y intégrer des appels API pour afficher les vrais favoris de l'utilisateur :

1. Modifiez [favorites.blade.php](file:///c:/GitHub/SmartDress/SmartDress_Mobile/resources/views/favorites.blade.php).
2. Ajoutez un bloc `@push('x-data-state')` pour stocker les favoris et appeler l'API :
```javascript
@push('x-data-state')
    favoris: [],
    loading: true,

    async init() {
        try {
            const token = localStorage.getItem('auth_token');
            const res = await fetch('http://10.0.2.2:8000/api/favoris-api', {
                headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
            });
            const json = await res.json();
            // Filtrer pour ne garder que les vêtements favoris (vetement_id !== null)
            this.favoris = (json.data || json).filter(f => f.vetement_id !== null);
            this.loading = false;
        } catch (err) {
            console.error(err);
            this.loading = false;
        }
    },

    async removeFavorite(id) {
        try {
            const token = localStorage.getItem('auth_token');
            await fetch(`http://10.0.2.2:8000/api/favoris-api/${id}`, {
                method: 'DELETE',
                headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
            });
            this.favoris = this.favoris.filter(f => f.id !== id);
        } catch (err) {
            console.error(err);
        }
    }
@endpush
```
3. Remplacez le contenu statique par une grille dynamique (`x-for="fav in favoris"`) qui affiche le vêtement associé (`fav.vetement.nom`, `fav.vetement.photos`, etc.).

---

## 👕 Étape 4 : Gestion du bouton favoris (Cœur) dans la Garde-Robe mobile
Dans la liste de la garde-robe, le clic sur le bouton cœur doit enregistrer ou retirer l'article des favoris via l'API :

1. Modifiez [wardrobe.blade.php](file:///c:/GitHub/SmartDress/SmartDress_Mobile/resources/views/wardrobe.blade.php).
2. Mettez en place une fonction Alpine.js `toggleFavorite(itemId)` :
   - Récupère le token d'authentification depuis le stockage local.
   - Fait une requête `POST` vers `/api/favoris-api` avec `vetement_id` pour ajouter.
   - Fait une requête `DELETE` vers `/api/favoris-api/{id}` pour retirer.
3. Dynamisez la couleur du cœur (rouge si favori, gris/vide sinon) en croisant les données avec la liste des favoris de l'utilisateur.

---

## ❌ Étape 5 : Exclusion stricte de la modale de Détails (Vérification mobile)
Comme pour l'application Web, le client a demandé de retirer complètement l'affichage de "Détails du vêtement".
- La modale et les écouteurs de clics de cartes ont **déjà été retirés** des fichiers prototypes HTML (`garde-robe_mobile.html` et `favoris_mobile.html`).
- Veillez à ce qu'**aucune** carte de vêtement dans `wardrobe.blade.php` ou `favorites.blade.php` n'écoute l'événement clic pour ouvrir une modale de détails. Le clic ne doit rien faire (ou uniquement rediriger, mais pas ouvrir de pop-up).

---

## 🏃 Étape 6 : Lancement et Compilation Android
Pour tester l'application mobile en conditions réelles sur votre émulateur Android :

1. Assurez-vous que le serveur web principal tourne sur le port `8000` (`php artisan serve` dans le dossier `smartdress`).
2. Ouvrez une console dans le dossier `SmartDress_Mobile`.
3. Lancez le script de configuration Android pour réinitialiser les dépendances et s'assurer que les binaires NDK sont en place :
   ```powershell
   .\setup-android.ps1
   ```
4. Lancez la compilation de l'application Android native via la commande NativePHP :
   ```bash
   php artisan native:run
   ```
5. L'application se lancera dans votre émulateur Android et se connectera dynamiquement aux données du serveur Laravel local.

---
⚡ *Fiche de route SmartDress Mobile — Rédigée par Antigravity*
