---
description: Recommandation de tenue et compatibilité avec la météo.
trigger: /user-outfit
---

# 👚 WORKFLOW : RECOMMANDATION DE TENUE

## Commande déclencheuse
`/user-outfit`

## Objectif
Vérifier l'utilisation de `OutfitRecommendationService` et l'intégration de la recommandation dans le dashboard utilisateur.

## Étapes d'exécution

1. Obtenir la température via `WeatherService` ou une valeur de test.
2. Appeler `OutfitRecommendationService::getBestOutfit($user, $temperature)`.
3. Afficher la tenue recommandée sur le dashboard si une tenue existe.
4. Proposer une alternative si l'utilisateur n'a pas assez de vêtements.

## Checklist
- [ ] Le service recommande une tenue en fonction de la météo.
- [ ] La page dashboard affiche un message utile si aucune tenue n'est disponible.
- [ ] Le calcul n'utilise pas de logique de présentation dans le service.
- [ ] Le flux Web est compatible avec les pages mobiles simplifiées.
