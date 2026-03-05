# Composition : Accueil

> **Source** : `wireframes/wireframe-accueil.md`

---

## 🔵 Atoms (Composants de base)
- **Logo** : `a-logo` (Image/SVG avec animation Pulse)
- **Titre H1** : `a-title-h1` (Hero text, Inter 700)
- **Bouton Primaire** : `a-btn-primary` (Gradient, Flat design)
- **Input Text** : `a-input-text` (Border-bottom, Floating label)
- **Lien** : `a-link` (Underline on hover, color-accent)

---

## 🟡 Molécules (Assemblages)
- **Hero Section** : `m-hero-splash`
    - Comprend : `a-logo` + `a-title-h1` + `a-btn-primary`
- **Tabs Auth** : `m-tabs-auth`
    - Comprend : 2x `a-link` (Actif/Inactif)
- **Formulaire Connexion** : `m-form-login`
    - Comprend : 2x `a-input-text` + `a-btn-primary` + `a-link` (oublié)
- **Social Connect** : `m-social-auth`
    - Comprend : Boutons icones Google/Apple
