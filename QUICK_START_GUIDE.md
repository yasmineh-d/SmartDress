# SmartDress API - Commandes de Déploiement

## 🚀 Démarrage Rapide (Développement)

### Terminal 1 - Serveur API (smartdress/Web)
```powershell
cd C:\GitHub\SmartDress\smartdress

# Première exécution uniquement:
composer install
php artisan migrate

# Démarrer le serveur:
php artisan serve
# → Accessible sur http://localhost:8000
# → Depuis mobile: http://10.0.2.2:8000
```

### Terminal 2 - Application Mobile
```powershell
cd C:\GitHub\SmartDress\SmartDress_Mobile

# Première exécution uniquement:
composer install
npm install
.\setup-android.ps1

# Déployer sur l'émulateur:
php artisan native:run
```

---

## ✅ Vérification de l'API

### Test 1: Login
```powershell
# Créer un utilisateur d'abord (dans la Web):
# http://localhost:8000/register

# Puis tester le login:
curl -X POST http://localhost:8000/api/login `
  -H "Content-Type: application/json" `
  -d '{
    "email": "test@example.com",
    "password": "password"
  }'

# Copier le token reçu pour les tests suivants
```

### Test 2: Lister les vêtements
```powershell
$token = "1|votre_token_ici"

curl -X GET http://localhost:8000/api/vetements `
  -H "Authorization: Bearer $token" `
  -H "Content-Type: application/json"
```

### Test 3: Ajouter un vêtement
```powershell
$token = "1|votre_token_ici"

curl -X POST http://localhost:8000/api/vetements `
  -H "Authorization: Bearer $token" `
  -H "Content-Type: application/json" `
  -d '{
    "nom": "Veste cuir",
    "categorie": "Haut",
    "couleur": "Noir",
    "saison": "automne,hiver",
    "style": "Casual"
  }'
```

### Test 4: Ajouter aux favoris
```powershell
$token = "1|votre_token_ici"

curl -X POST http://localhost:8000/api/favoris `
  -H "Authorization: Bearer $token" `
  -H "Content-Type: application/json" `
  -d '{
    "vetement_id": 1
  }'
```

---

## 🔍 Vérification du Statut

### Vérifier les routes API
```bash
cd smartdress
php artisan route:list | grep api
```

### Vérifier les migrations
```bash
cd smartdress
php artisan migrate:status
```

### Vérifier la base de données
```bash
cd smartdress
# Si MySQL est actif:
mysql -u root -p smartdress
# SELECT COUNT(*) FROM vetements;
# SELECT COUNT(*) FROM users;
```

### Vérifier les logs
```bash
cd smartdress
tail -f storage/logs/laravel.log
```

---

## 🐛 Dépannage Rapide

### L'API ne répond pas
```bash
# Vérifier que le serveur est actif:
curl http://localhost:8000/api/login -v

# Vérifier le statut du port 8000:
netstat -ano | findstr :8000

# Redémarrer le serveur:
# Ctrl+C dans le terminal
php artisan serve
```

### Erreur 419 (CSRF)
- Ne pas inquiétant pour l'API
- Les routes API n'utilisent pas CSRF
- Vérifier le header Authorization

### Erreur 401 (Non autorisé)
```bash
# Token expiré?
# Refaire un login pour obtenir un nouveau token

# Vérifier que le user_id est bon:
cd smartdress
php artisan tinker
>>> User::all();
```

### Erreur de migration
```bash
# Si tables manquent:
cd smartdress
php artisan migrate --path=database/migrations

# Si erreur persist:
php artisan migrate:fresh --seed  # ⚠️ Efface TOUT
```

### Permissions fichier storage
```bash
cd smartdress
# Linux/Mac:
chmod -R 775 storage bootstrap/cache

# Windows: Utiliser l'explorateur fichier ou:
icacls "storage" /grant:r "Utilisateurs:(OI)(CI)F" /t
```

---

## 📊 Structure des Données

### Utilisateurs
```sql
SELECT id, name, email FROM users;
```

### Vêtements
```sql
SELECT id, nom, categorie, couleur, user_id FROM vetements;
SELECT * FROM photos WHERE vetement_id = 1;
SELECT * FROM saisons;
```

### Favoris
```sql
SELECT * FROM favoris WHERE user_id = 1;
```

### Tenues
```sql
SELECT * FROM tenues WHERE user_id = 1;
SELECT * FROM tenue_vetement WHERE tenue_id = 1;
```

---

## 📱 Test sur l'Application Mobile

1. **Lancer l'app**: `php artisan native:run`
2. **Se connecter**: Utiliser un compte créé en Web
3. **Ajouter vêtement**: 
   - Cliquer sur le "+" central
   - Remplir le formulaire
   - Vérifier que c'est sauvegardé en Web
4. **Ajouter aux favoris**: 
   - Cliquer sur le cœur d'un vêtement
   - Vérifier que la couleur change
5. **Voir les favoris**: 
   - Onglet "Mes Favoris"
   - Doit afficher les articles marqués

---

## 🔄 Workflow Complet

```
┌─ Utilisateur SE CONNECTE
│  └─ POST /api/login → Récoit token
│
├─ Utilisateur AJOUTE VÊTEMENT
│  └─ POST /api/vetements + photo
│     └─ Stocké en BD smartdress
│
├─ Utilisateur VOIT SES VÊTEMENTS
│  └─ GET /api/vetements
│     └─ Récupère de BD smartdress
│
├─ Utilisateur AJOUTE AUX FAVORIS
│  └─ POST /api/favoris {vetement_id}
│     └─ Créé en favoris table
│
└─ Utilisateur VOIT FAVORIS
   └─ GET /api/favoris
      └─ Retourne vêtements + tenues favoris
```

---

## 📋 Checklist de Vérification

- [ ] `php artisan serve` actif sur port 8000
- [ ] Base de données `smartdress` créée
- [ ] Migrations exécutées: `php artisan migrate`
- [ ] Utilisateurs créés (Web register ou Tinker)
- [ ] CORS configuré dans `config/cors.php`
- [ ] Sanctum configuré dans User model
- [ ] Storage lié: `php artisan storage:link`
- [ ] SmartDress_Mobile pointe vers `http://10.0.2.2:8000`
- [ ] Émulateur Android lancé
- [ ] `php artisan native:run` compile l'app

---

## 🔗 Liens Utiles

- **Swagger/Docs**: Non configuré (ajouter plus tard)
- **Tinker REPL**: `php artisan tinker`
- **DB Manager**: PhpMyAdmin (si installé)
- **Logs API**: `storage/logs/laravel.log`

---

**Dernière mise à jour**: June 9, 2026
