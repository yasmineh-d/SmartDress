---
trigger: /service-layer
type: rule
id: smartdress-service-layer
---

# DIRECTIVES DE LA COUCHE SERVICES - SMARTDRESS

## Principes

- Les services en `app/Services/` sont le cœur de la logique métier.
- Les contrôleurs doivent déléguer : valider la requête, appeler le service, renvoyer la réponse.
- Les services doivent être testables, indépendants du framework HTTP.

## Services recommandés

1. **OutfitRecommendationService**
   - Recommande les tenues selon la météo et le contenu du dressing.
   - Ne doit pas faire de logique de route ou de session.

2. **WardrobeService**
   - Valide qu'un utilisateur peut créer une tenue (Haut/Bas/Chaussures).
   - Récupère les favoris et les vêtements utiles pour la garde-robe.

3. **ImageUploadService**
   - Gère le renommage des fichiers, l'upload et la suppression des images liées aux vêtements.
   - Utiliser `Storage::disk('public')` et stocker les chemins relatifs.

4. **VetementService**
   - Encapsule les règles de création, mise à jour et suppression de vêtements.

5. **AdminDashboardService**
   - Calcule les métriques du tableau de bord admin et agrège les activités.

## Règles d'écriture

- Encapsuler les transactions dans `DB::transaction(...)` lorsque plusieurs opérations de base doivent réussir ensemble.
- Lever des exceptions explicites si la précondition métier n'est pas satisfaite (`AuthorizationException`, `ValidationException`).
- Retourner des résultats cohérents : booléen, modèle, collection ou tableau associatif.

## Exemple

```php
public function retirerVetement(int $vetementId, User $user): bool
{
    $vetement = $user->vetements()->findOrFail($vetementId);
    $this->imageUploadService->deletePhoto($vetement->photos);
    return $vetement->delete();
}
```
