# Composition : Garde-Robe

> **Source** : `wireframes/wireframe-garde-robe.md`

---

## 🔵 Atoms (Composants de base)
- **Bouton Retour** : `a-btn-back` (Icone Arrow)
- **Input Search** : `a-input-search` (Avec icône loupe)
- **Tab Item** : `a-tab-item` (Pill design pour catégories)
- **Image Miniature** : `a-img-thumb` (Aspect ratio 1:1, Rounded)
- **Bouton FAB** : `a-btn-fab` (Cercle flottant, Ombre portée)

---

## 🟡 Molécules (Assemblages)
- **Header Maigre** : `m-header-sub`
    - Comprend : `a-btn-back` + `a-title-h1` + `a-input-search`
- **Sélecteur Catégorie** : `m-category-selector`
    - Comprend : Liste horizontale de `a-tab-item`
- **Carte Vêtement** : `m-card-clothing`
    - Comprend : `a-img-thumb` + `a-badge` (Couleur) + Label
- **Grille Vêtements** : `m-grid-clothing`
    - Comprend : Répétition de `m-card-clothing`
