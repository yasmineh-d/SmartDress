# Guide de Déploiement API SmartDress

## Architecture
```
┌─────────────────────────────────────┐
│  SmartDress_Mobile (Émulateur)      │
│  http://10.0.2.2:8000/api/*         │
└────────────┬────────────────────────┘
             │ (HTTP Requests)
             ↓
┌─────────────────────────────────────┐
│  SmartDress (Web) - API Server      │
│  php artisan serve (port 8000)      │
│  - Contrôleurs API                  │
│  - Sanctum Authentication           │
│  - Base de données existante        │
└─────────────────────────────────────┘
```

## Prérequis

### 1. Base de Données (smartdress/Web)
✅ Migrations exécutées:
- `create_users_table`
- `create_vetements_table`
- `create_photos_table`
- `create_favoris_table`
- `create_tenues_table`
- `add_saisons_to_vetements_table`

### 2. Configuration Sanctum
Le modèle User charge déjà `HasApiTokens`. Table `personal_access_tokens` doit exister:

```bash
cd smartdress
php artisan migrate  # Exécute toutes les migrations
```

### 3. Configuration CORS
✅ `config/cors.php` est déjà configuré:
- `allowed_origins: '*'` 
- `allowed_methods: '*'`
- `allowed_headers: '*'`

---

## Endpoints API Disponibles

### Authentification
```
POST /api/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "password"
}

Response (201):
{
  "success": true,
  "token": "1|AbcDef...",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "user@example.com"
  }
}
```

### Vêtements
```
GET /api/vetements
Authorization: Bearer {token}

POST /api/vetements
Authorization: Bearer {token}
Content-Type: multipart/form-data

{
  "nom": "Veste cuir",
  "categorie": "Haut",
  "couleur": "Noir",
  "saison": "automne,hiver",
  "photo": <file>
}

GET /api/vetements/{id}
Authorization: Bearer {token}

PUT /api/vetements/{id}
Authorization: Bearer {token}

DELETE /api/vetements/{id}
Authorization: Bearer {token}
```

### Favoris
```
GET /api/favoris
Authorization: Bearer {token}

POST /api/favoris
Authorization: Bearer {token}
Content-Type: application/json

{
  "vetement_id": 5
  // OU
  "tenue_id": 3
}

DELETE /api/favoris/{id}
Authorization: Bearer {token}
```

### Tenues
```
GET /api/tenues
Authorization: Bearer {token}

POST /api/tenues
Authorization: Bearer {token}
Content-Type: application/json

{
  "nom": "Look d'été",
  "meteo_adaptee": "Beau",
  "conseil_ia": "Léger et confortable"
}

PUT /api/tenues/{id}
DELETE /api/tenues/{id}
```

---

## Procédure de Déploiement

### Étape 1: Préparer le serveur API (smartdress)
```bash
cd C:\GitHub\SmartDress\smartdress

# 1. Installer les dépendances
composer install

# 2. Créer le .env (si absent)
cp .env.example .env

# 3. Générer la clé d'application
php artisan key:generate

# 4. Exécuter les migrations
php artisan migrate

# 5. Démarrer le serveur (reste actif)
php artisan serve
# → API accessible sur http://localhost:8000
# → Depuis l'émulateur: http://10.0.2.2:8000
```

### Étape 2: Configuration SmartDress_Mobile
```bash
cd C:\GitHub\SmartDress\SmartDress_Mobile

# 1. Installer les dépendances
composer install
npm install

# 2. Vérifier .env si nécessaire
# BASE_API_URL=http://10.0.2.2:8000 (pour l'émulateur)

# 3. Compiler avec Vite
npm run build
# OU en développement
npm run dev
```

### Étape 3: Lancer l'application mobile
```bash
cd C:\GitHub\SmartDress\SmartDress_Mobile

# Option A: Setup Android (première fois seulement)
.\setup-android.ps1  # Configure Android SDK et PHP 8.4

# Option B: Compiler et déployer
php artisan native:run
```

### Étape 4: Vérifier la connexion
1. Ouvrir l'application mobile
2. Se connecter avec les identifiants d'un utilisateur existant
3. Ajouter un vêtement (teste POST)
4. Vérifier que les données apparaissent en Web
5. Ajouter aux favoris (teste le cœur)

---

## Dépannage

### Erreur 401 (Non autorisé)
- Token expiré ou invalide
- Vérifier que le header `Authorization: Bearer {token}` est envoyé
- Relancer `php artisan serve`

### Erreur 404 (Route non trouvée)
- Vérifier que `php artisan serve` est actif sur le port 8000
- Vérifier les routes: `php artisan route:list | grep api`

### Erreur CORS
- Ne pas se produire (CORS autorise tout)
- Vérifier `config/cors.php`

### Pas de photo sauvegardée
- Vérifier permissions: `storage/app/public`
- Vérifier que le storage est lié: `php artisan storage:link`

### Erreur de migration
```bash
# Si migrations manquent:
php artisan migrate:fresh --seed  # ATTENTION: Efface tout

# Ou manuellement:
php artisan migrate --path=database/migrations
```

---

## Fichiers Clés

- **API Routes**: `smartdress/routes/api.php`
- **Controllers**: `smartdress/app/Http/Controllers/Api/`
- **Models**: `smartdress/app/Models/`
- **Services**: `smartdress/app/Services/`
- **Mobile Views**: `SmartDress_Mobile/resources/views/`
- **Mobile API Client**: `SmartDress_Mobile/resources/views/layouts/mobile.blade.php` (Alpine.js)

---

## Vérification des Services

Les contrôleurs API utilisent des services (VetementService, FavorisService, etc.). 
Vérifier qu'ils existent dans `smartdress/app/Services/`:

```bash
ls smartdress/app/Services/
```

Si un service manque, voir le contrôleur correspondant pour comprendre son interface.

---

## Notes de Sécurité

⚠️ **Production (à faire après POC)**:
1. Changer `allowed_origins: '*'` → `allowed_origins: ['https://yourdomain.com']`
2. Ajouter rate limiting sur `/api/login`
3. Ajouter refresh tokens
4. HTTPS mandatory
5. CORS credentials pour l'API

✅ **Pour le développement**: Configuration actuelle OK

---

**Dernière mise à jour**: June 9, 2026
