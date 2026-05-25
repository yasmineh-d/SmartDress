---
name: smartdress-builder
description: Logique métier, services et règles applicatives pour SmartDress.
---

# 🔨 COMPÉTENCE : SMARTDRESS BUILDER

## Rôle et domaine d'action
Cette compétence gère la logique métier de **SmartDress**. Elle organise les services qui calculent les recommandations, valident la garde-robe et gèrent les fichiers.

## Services clés

### `OutfitRecommendationService`
- Recommande une tenue par utilisateur selon la météo.
- Doit se baser sur `User->tenues()` et ne pas dépendre des routes ou de la session.

### `WardrobeService`
- Vérifie qu'un utilisateur dispose au minimum d'un haut, un bas et des chaussures.
- Récupère les favoris parcimonieusement.

### `ImageUploadService`
- Gère l'upload sécurisé des photos de vêtements.
- Utilise `Storage::disk('public')` et normalise les chemins.
- Supprime les fichiers lors de la suppression d'un vêtement.

### `VetementService`
- Centralise la création, la mise à jour et la suppression de vêtements.
- Doit gérer la validation des règles métier et l'appel à l'`ImageUploadService`.

### `AdminDashboardService`
- Calcule les métriques d'administration.
- Agrège les activités et prépare les données pour le dashboard.

## Bonnes pratiques

- Les services doivent retourner : modèle, collection ou tableau, pas de logique HTML.
- Encapsuler les ensembles d'opérations dans `DB::transaction` quand plusieurs écritures dépendent les unes des autres.
- Lever des exceptions métier claires (`ModelNotFoundException`, `AuthorizationException`).
- Ne pas utiliser les services pour manipuler directement les vues ou les sessions.

## Exemple d'appel

```php
public function store(Request $request, VetementService $vetementService)
{
    $vetement = $vetementService->createFromRequest($request, auth()->user());
    return redirect()->route('garde-robe')->with('success', 'Vêtement ajouté avec succès !');
}
```
