# Composition : Dashboard

> **Source** : `wireframes/wireframe-dashboard.md`

---

## 🔵 Atoms (Composants de base)
- **Icone** : `a-icon` (Lucide Icons / Feather)
- **Avatar** : `a-avatar` (Cercle, Image/Initiale)
- **Titre H1** : `a-title-h1` (Inter 600)
- **Bouton Primaire** : `a-btn-primary`
- **Bouton Fantôme** : `a-btn-ghost` (Bordures transparentes)
- **Tag / Badge** : `a-badge` (Pill shape)

---

## 🟡 Molécules (Assemblages)
- **Top Bar** : `m-top-bar`
    - Comprend : `a-icon` (Burger) + `a-title` + `a-avatar`
- **Widget Météo** : `m-widget-weather`
    - Comprend : `a-icon` (météo) + Textes (Ville/Temp)
- **Carte Suggestion** : `m-card-suggestion`
    - Comprend : `a-title-h1` + Image (Tenue) + `a-btn-primary` + `a-btn-ghost`
- **Menu Grille** : `m-grid-nav`
    - Comprend : Liste de `m-nav-item` (Icone + Label)
