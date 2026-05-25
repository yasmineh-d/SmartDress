---
name: smartdress-architect
description: Modélisation de données, relations Eloquent et intégrité des migrations pour SmartDress.
---

# 🏗️ COMPÉTENCE : SMARTDRESS ARCHITECT

## Rôle et domaine d'action
Cette compétence gère l'architecture des données de **SmartDress**. Elle veille à la qualité des modèles, des relations et des migrations.

## Principales entités

### 1. Modèle User
```php
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password'];

    public function vetements() { return $this->hasMany(Vetement::class); }
    public function tenues() { return $this->hasMany(Tenue::class); }
    public function favoris() { return $this->hasMany(Favoris::class); }
    public function roles() { return $this->belongsToMany(Role::class, 'role_user'); }
}
```

### 2. Modèle Vetement
```php
class Vetement extends Model
{
    protected $fillable = ['nom', 'categorie', 'couleur', 'saison', 'style', 'user_id'];

    public function user() { return $this->belongsTo(User::class); }
    public function photos() { return $this->hasMany(Photo::class); }
    public function tenues() { return $this->belongsToMany(Tenue::class, 'tenue_vetement'); }
}
```

### 3. Modèle Tenue
```php
class Tenue extends Model
{
    protected $fillable = ['nom', 'meteo_adaptee', 'conseil_ia', 'user_id'];

    public function user() { return $this->belongsTo(User::class); }
    public function vetements() { return $this->belongsToMany(Vetement::class, 'tenue_vetement'); }
}
```

### 4. Modèle Favoris
```php
class Favoris extends Model
{
    protected $fillable = ['user_id', 'vetement_id', 'tenue_id'];

    public function user() { return $this->belongsTo(User::class); }
    public function vetement() { return $this->belongsTo(Vetement::class); }
    public function tenue() { return $this->belongsTo(Tenue::class); }
}
```

### 5. Modèle Photo
```php
class Photo extends Model
{
    protected $fillable = ['vetement_id', 'url', 'dateUpload'];

    public function vetement() { return $this->belongsTo(Vetement::class); }
}
```

## Directives d'intégrité
- Toujours définir `fillable` explicitement pour chaque modèle.
- Appliquer les contraintes `onDelete('cascade')` sur les clés étrangères quand la suppression doit nettoyer les dépendances.
- Préférer les clés primaires auto-incrémentées et les identifiants explicites plutôt que des `guarded` globaux.
- Ne jamais mélanger la logique métier des relations dans les migrations.
