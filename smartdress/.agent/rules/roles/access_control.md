---
trigger: /access-control
type: rule
id: smartdress-access-control
---

# RÈGLE RBAC - SMARTDRESS

## Rôles et permissions

Le projet SmartDress utilise une gestion simple de rôles via les modèles `Role` et `Permission`.

### Rôles identifiés
- `admin` : accès au tableau de bord admin et à la gestion des utilisateurs.
- `user` : accès à la garde-robe, aux tenues, aux favoris et au profil.

### Bonnes pratiques

- Vérifier le rôle avant d'exposer une page admin.
- Dans les routes, protéger les zones sensibles avec un middleware `auth` ou un middleware personnalisé `role:admin`.
- Ne pas confondre `User` et `Utilisateur` si les deux modèles coexistent.

## Exemple

```php
public function index()
{
    $this->authorize('viewAdminDashboard');

    return view('pages.admin.admin-dashboard');
}
```

> Si le projet n'a pas encore de middleware RBAC complet, utiliser `auth()->user()?->hasRole('admin')` comme garde-fou temporaire.
