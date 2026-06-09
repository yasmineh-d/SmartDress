<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDress - Mes Favoris</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400;1,600&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        bark: '#5C4A35',
                        moss: '#889063',
                        tan: '#CFBB99',
                        bone: '#E5D7C4',
                        cream: '#F5EEE4',
                        offwhite: '#FDFAF6',
                        deeptan: '#B8A07E',
                    },
                    fontFamily: {
                        display: ['"Cormorant Garamond"', 'serif'],
                        body: ['"DM Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="../../assets/css/charte.css">
    <link rel="stylesheet" href="../../assets/css/style-landing.css">
    <script src="https://cdn.jsdelivr.net/npm/preline/dist/preline.js"></script>
</head>

<body class="bg-offwhite font-body text-bark min-h-screen flex flex-col">

    <!-- Header -->
    <header id="navbar" class="sd-navbar scrolled !fixed !bg-white/90">
        <div class="max-w-screen-xl mx-auto px-6 lg:px-12 flex items-center h-full gap-12">
            <a href="{{ url('/') }}" class="sd-logo">Smart<span>Dress</span></a>

            <nav class="hidden lg:flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="sd-navlink">Dashboard</a>
                <a href="{{ route('garde-robe') }}" class="sd-navlink">Garde-Robe</a>
                <a href="{{ route('favoris') }}" class="sd-navlink !opacity-100 !text-moss font-bold border-b-2 border-moss pb-1">Favoris</a>
                <a href="{{ route('profile') }}" class="sd-navlink">Profil</a>
            </nav>

            <div class="ml-auto hidden lg:flex items-center gap-3">
                @auth
                <div class="flex items-center gap-3">
                    <a href="{{ route('profile') }}"
                        class="flex items-center gap-2 px-4 py-2 bg-cream/50 rounded-full text-xs font-bold text-bark hover:bg-cream transition-all border border-tan/10">
                        <div class="w-6 h-6 bg-tan rounded-full flex items-center justify-center text-[10px] text-white">
                            {{ auth()->user()->initials() }}
                        </div>
                        {{ auth()->user()->name }}
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-xs font-bold text-tan hover:text-bark uppercase tracking-widest px-2 transition-all">Déconnexion</button>
                    </form>
                </div>
                @else
                <div class="flex items-center gap-3">
                    <a href="{{ route('login', ['mode' => 'login']) }}" class="sd-btn-ghost">Se connecter</a>
                    <a href="{{ route('login', ['mode' => 'register']) }}" class="sd-btn-primary">Commencer</a>
                </div>
                @endauth
            </div>
        </div>
    </header>

    <div class="h-20"></div>

    <main class="flex-1 max-w-7xl w-full mx-auto p-8 flex gap-8">

        <!-- Sidebar gauche -->
        <aside class="w-56 shrink-0 space-y-8">

            <!-- Catégories -->
            <div class="bg-white rounded-[2rem] shadow-xl shadow-bark/5 border border-tan/10 p-6 space-y-3">
                <h3 class="text-[10px] font-bold text-tan uppercase tracking-widest mb-4">Catégories</h3>

                @php
                    $categories = ['hauts', 'bas', 'chaussures', 'accessoires'];
                    $totalFavoris = $favoris->count();
                @endphp

                <button id="btn-cat-all" onclick="setSidebarCategory('all')"
                    class="sidebar-cat-btn w-full flex items-center justify-between px-4 py-3 bg-moss text-white rounded-xl shadow-md text-sm font-bold transition-all">
                    <span>Tout</span>
                    <span class="opacity-60 font-medium tracking-wider">{{ $totalFavoris }}</span>
                </button>

                @foreach($categories as $cat)
                    @php
                        $count = $favoris->filter(function($f) use ($cat) {
                            return $f->vetement && $f->vetement->categorie === $cat;
                        })->count();
                    @endphp
                    <button id="btn-cat-{{ $cat }}" onclick="setSidebarCategory('{{ $cat }}')"
                        class="sidebar-cat-btn w-full flex items-center justify-between px-4 py-3 text-bark hover:bg-cream/50 rounded-xl text-sm font-medium transition-colors">
                        <span class="capitalize">{{ ucfirst($cat) }}</span>
                        <span class="text-tan font-bold tracking-wider">{{ $count }}</span>
                    </button>
                @endforeach
            </div>

            <!-- Saisons -->
            <div class="bg-white rounded-[2rem] shadow-xl shadow-bark/5 border border-tan/10 p-6 space-y-3">
                <h3 class="text-[10px] font-bold text-tan uppercase tracking-widest mb-4">Saisons</h3>
                <div class="flex flex-wrap gap-2">
                    <button id="btn-season-hiver" onclick="setSeasonFilter('hiver')"
                        class="season-btn px-3 py-1.5 bg-cream/50 text-bark text-xs font-medium rounded-full border border-tan/10 cursor-pointer hover:bg-moss hover:text-white transition-all">Hiver</button>
                    <button id="btn-season-printemps" onclick="setSeasonFilter('printemps')"
                        class="season-btn px-3 py-1.5 bg-cream/50 text-bark text-xs font-medium rounded-full border border-tan/10 cursor-pointer hover:bg-moss hover:text-white transition-all">Printemps</button>
                    <button id="btn-season-ete" onclick="setSeasonFilter('ete')"
                        class="season-btn px-3 py-1.5 bg-cream/50 text-bark text-xs font-medium rounded-full border border-tan/10 cursor-pointer hover:bg-moss hover:text-white transition-all">Été</button>
                    <button id="btn-season-automne" onclick="setSeasonFilter('automne')"
                        class="season-btn px-3 py-1.5 bg-cream/50 text-bark text-xs font-medium rounded-full border border-tan/10 cursor-pointer hover:bg-moss hover:text-white transition-all">Automne</button>
                </div>
            </div>


        </aside>

        <!-- Contenu principal -->
        <section class="flex-1">

            <!-- Header + Search -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-4xl font-display font-medium text-bark italic">Mes <span class="text-moss">Favoris</span></h1>
                    <p class="text-sm text-tan mt-1">Affichage de <span id="item-count">{{ $favoris->count() }}</span> articles</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-tan absolute left-4 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" id="search-input" placeholder="Rechercher un article..." 
                            class="pl-11 pr-5 py-3 bg-white border border-tan/10 rounded-2xl text-sm focus:border-moss outline-none transition-all w-64">
                    </div>
                    <select id="filter-select" class="px-5 py-3 bg-white border border-tan/10 rounded-2xl text-sm text-bark focus:border-moss outline-none transition-all">
                        <option value="all">Toutes catégories</option>
                        <option value="hauts">Hauts</option>
                        <option value="bas">Bas</option>
                        <option value="chaussures">Chaussures</option>
                        <option value="accessoires">Accessoires</option>
                    </select>
                </div>
            </div>

            <!-- Grille des favoris -->
            @if($favoris->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($favoris as $favori)
                        @if($favori->vetement)
                            @php 
                                $vetement = $favori->vetement; 
                                $photo = $vetement->photos ? $vetement->photos->first() : null;
                                $category = strtolower($vetement->categorie);
                                
                                $saisonsList = '';
                                if (is_array($vetement->saison)) {
                                    $saisonsList = implode(',', array_map('strtolower', $vetement->saison));
                                } elseif (is_string($vetement->saison)) {
                                    $saisonsList = strtolower($vetement->saison);
                                }

                                $formattedSaison = 'Sans saison';
                                if (!empty($vetement->saison)) {
                                    if (is_array($vetement->saison)) {
                                        $formattedSaison = implode(', ', array_map(function($s) {
                                            $s = strtolower($s);
                                            if ($s === 'ete') return 'Été';
                                            return ucfirst($s);
                                        }, $vetement->saison));
                                    } else {
                                        $s = strtolower($vetement->saison);
                                        $formattedSaison = ($s === 'ete') ? 'Été' : ucfirst($s);
                                    }
                                }
                            @endphp
                            <div data-category="{{ $category }}" data-saison="{{ $saisonsList }}"
                                data-nom="{{ $vetement->nom }}"
                                data-display-saison="{{ $formattedSaison }}"
                                data-couleur="{{ $vetement->couleur ?? 'Non spécifiée' }}"
                                data-style="{{ $vetement->style ?? 'Non spécifié' }}"
                                data-image="{{ $photo ? asset('storage/' . $photo->url) : '' }}"
                                data-emoji="{{ $category === 'hauts' ? '👕' : ($category === 'bas' ? '👖' : ($category === 'chaussures' ? '👟' : '👜')) }}"
                                class="clothing-card group bg-white rounded-[2rem] border border-tan/10 shadow-lg shadow-bark/5 overflow-hidden hover:shadow-xl hover:border-moss/30 transition-all duration-300 relative">

                                <!-- Boutons d'actions au survol (coeur et oeil) -->
                                <div class="absolute top-4 right-4 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                                    <form action="{{ route('favoris-api.destroy', $favori->id) }}" method="POST" class="m-0 p-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 bg-white border border-tan/10 rounded-full flex items-center justify-center shadow-sm text-red-500 hover:text-red-600 transition-colors" title="Retirer des favoris">
                                            <svg class="w-4 h-4 fill-red-500 text-red-500" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                        </button>
                                    </form>
                                    <button onclick="openDetailsModal(this)" type="button"
                                        class="w-8 h-8 bg-white border border-tan/10 rounded-full flex items-center justify-center text-tan hover:text-bark shadow-sm"
                                        title="Voir détails">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Image -->
                                <div class="aspect-square bg-cream/20 flex items-center justify-center overflow-hidden">
                                    @if($vetement->photos && $vetement->photos->count() > 0)
                                        <img src="{{ asset('storage/' . $vetement->photos->first()->url) }}"
                                            alt="{{ $vetement->nom }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        @php
                                            $emojis = ['hauts' => '👕', 'bas' => '👖', 'chaussures' => '👟', 'accessoires' => '👜'];
                                            $emoji = $emojis[$vetement->categorie] ?? '👗';
                                        @endphp
                                        <span class="text-6xl">{{ $emoji }}</span>
                                    @endif
                                </div>

                                <!-- Info -->
                                <div class="p-4">
                                    <p class="text-[9px] font-bold text-tan uppercase tracking-widest mb-1">
                                        {{ ucfirst($vetement->categorie) }} / {{ $formattedSaison }}
                                    </p>
                                    <p class="text-sm font-display italic text-bark">{{ $vetement->nom }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <!-- État vide -->
                <div class="flex flex-col items-center justify-center py-32 text-center">
                    <div class="w-24 h-24 bg-cream rounded-[2rem] flex items-center justify-center text-5xl mb-6 shadow-inner">
                        ⭐
                    </div>
                    <h3 class="text-2xl font-display italic text-bark mb-2">Aucun favori pour le moment</h3>
                    <p class="text-tan text-sm mb-8">Ajoutez des vêtements à vos favoris depuis votre garde-robe.</p>
                    <a href="{{ route('garde-robe') }}" class="px-8 py-4 bg-moss text-white rounded-full text-xs font-bold uppercase tracking-widest hover:bg-bark transition-all shadow-xl shadow-moss/20">
                        Aller à la garde-robe
                    </a>
                </div>
            @endif
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-bark text-white mt-20">
        <div class="max-w-screen-xl mx-auto px-6 lg:px-12 py-16 grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="space-y-4">
                <div class="text-xl font-display font-medium">Smart<span class="italic text-tan">Dress</span></div>
                <p class="text-xs text-white/50 leading-relaxed font-light">Votre garde-robe digitale intelligente. Suggestions de tenues basées sur la météo et vos préférences.</p>
            </div>
            <div class="space-y-4">
                <h4 class="text-[10px] font-bold uppercase tracking-widest text-tan">Application</h4>
                <ul class="space-y-2 text-xs text-white/60">
                    <li><a href="{{ route('dashboard') }}" class="hover:text-white transition-colors">Dashboard</a></li>
                    <li><a href="{{ route('garde-robe') }}" class="hover:text-white transition-colors">Garde-Robe</a></li>
                    <li><a href="{{ route('favoris') }}" class="hover:text-white transition-colors">Favoris</a></li>
                </ul>
            </div>
            <div class="space-y-4">
                <h4 class="text-[10px] font-bold uppercase tracking-widest text-tan">Compte</h4>
                <ul class="space-y-2 text-xs text-white/60">
                    <li><a href="{{ route('profile') }}" class="hover:text-white transition-colors">Mon profil</a></li>
                    <li><a href="{{ route('logout') }}" class="hover:text-white transition-colors">Déconnexion</a></li>
                </ul>
            </div>
            <div class="space-y-4">
                <h4 class="text-[10px] font-bold uppercase tracking-widest text-tan">Projet</h4>
                <ul class="space-y-2 text-xs text-white/60">
                    <li><a href="#" class="hover:text-white transition-colors">À propos</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">Contact</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Mentions légales</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10 px-6 lg:px-12 py-6 flex items-center justify-between text-[10px] text-white/30">
            <span>© 2025–2026 SmartDress · {{ auth()->user()->name ?? 'Yasmine Haddad' }}</span>
            <span>Formation Développement Mobile · Mode Bootcamp</span>
        </div>
    </footer>

    <!-- Toast Notifications -->
    @if ($errors->any() || session('success') || session('error'))
        <div class="fixed bottom-28 right-5 z-[100] flex flex-col gap-3 max-w-sm pointer-events-none">
            @if (session('success'))
                <div class="pointer-events-auto p-4 rounded-3xl bg-moss/95 backdrop-blur-md text-white shadow-2xl border border-white/20 flex items-center gap-3">
                    <span class="text-xl">✨</span>
                    <div>
                        <h5 class="font-bold text-xs uppercase tracking-wider text-cream">Succès</h5>
                        <p class="text-xs font-light opacity-90">{{ session('success') }}</p>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="pointer-events-auto p-4 rounded-3xl bg-bark/95 backdrop-blur-md text-white shadow-2xl border border-red-500/20 flex items-center gap-3">
                    <span class="text-xl">⚠️</span>
                    <div>
                        <h5 class="font-bold text-xs uppercase tracking-wider text-red-300">Erreur</h5>
                        <p class="text-xs font-light opacity-90">{{ session('error') }}</p>
                    </div>
                </div>
            @endif
        </div>
    @endif

    <!-- Overlay / Backdrop -->
    <div id="modal-overlay"
        class="fixed inset-0 bg-bark/60 backdrop-blur-sm z-50 hidden opacity-0 transition-opacity duration-300"></div>

    <!-- Modal : Détails d'un vêtement -->
    <div id="modal-details"
        class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white rounded-[3rem] shadow-2xl z-[60] hidden opacity-0 scale-95 transition-all duration-300 w-full max-w-2xl p-10">
        <div class="flex items-center justify-between mb-8">
            <div class="space-y-1">
                <h2 class="text-3xl font-display font-medium text-bark italic" id="details-title-display">Détails du <span class="text-moss">Vêtement</span></h2>
                <p class="text-tan text-xs font-medium uppercase tracking-widest" id="details-category-display">Catégorie</p>
            </div>
            <button onclick="closeModal('modal-details')"
                class="w-12 h-12 flex items-center justify-center bg-cream/50 rounded-2xl text-tan hover:text-bark hover:bg-cream transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Zone Image -->
            <div class="aspect-square bg-cream/20 border border-tan/10 rounded-[2.5rem] flex items-center justify-center overflow-hidden relative">
                <img id="details-image-display" class="w-full h-full object-contain p-4 hidden" alt="Détails vêtement">
                <span id="details-emoji-display" class="text-8xl hidden">👕</span>
            </div>

            <!-- Zone Fiche Technique -->
            <div class="flex flex-col justify-between py-2 space-y-6">
                <div class="space-y-4">
                    <div class="border-b border-tan/10 pb-3">
                        <span class="text-[10px] font-bold text-tan uppercase tracking-widest block mb-1">Nom</span>
                        <p class="text-lg font-medium text-bark" id="details-nom-display">Nom du vêtement</p>
                    </div>

                    <div class="border-b border-tan/10 pb-3">
                        <span class="text-[10px] font-bold text-tan uppercase tracking-widest block mb-1">Saisons</span>
                        <p class="text-sm font-medium text-bark" id="details-saison-display">Printemps, Été</p>
                    </div>

                    <div class="border-b border-tan/10 pb-3">
                        <span class="text-[10px] font-bold text-tan uppercase tracking-widest block mb-1">Couleur</span>
                        <p class="text-sm font-medium text-bark" id="details-couleur-display">Non spécifiée</p>
                    </div>

                    <div>
                        <span class="text-[10px] font-bold text-tan uppercase tracking-widest block mb-1">Style</span>
                        <p class="text-sm font-medium text-bark" id="details-style-display">Non spécifié</p>
                    </div>
                </div>

                <button onclick="closeModal('modal-details')"
                    class="w-full py-4 bg-moss text-white rounded-full text-[10px] font-bold uppercase tracking-[0.2em] shadow-xl shadow-moss/20 hover:bg-bark transition-all mt-4">
                    Fermer
                </button>
            </div>
        </div>
    </div>

    <script>
        // ── Search & Filter Logic ──
        const searchInput = document.getElementById('search-input');
        const filterSelect = document.getElementById('filter-select');
        const cards = document.querySelectorAll('.clothing-card');
        const itemCount = document.getElementById('item-count');

        let activeSeason = 'all';

        function setSeasonFilter(season) {
            if (activeSeason === season) {
                activeSeason = 'all';
            } else {
                activeSeason = season;
            }

            // Update season buttons active class styling
            const buttons = document.querySelectorAll('.season-btn');
            buttons.forEach(btn => {
                const btnSeason = btn.id.replace('btn-season-', '');
                if (btnSeason === activeSeason) {
                    btn.classList.add('bg-moss', 'border-moss', 'text-white');
                    btn.classList.remove('bg-cream/50', 'text-bark', 'border-tan/10');
                } else {
                    btn.classList.remove('bg-moss', 'border-moss', 'text-white');
                    btn.classList.add('bg-cream/50', 'text-bark', 'border-tan/10');
                }
            });

            filterItems();
        }

        function setSidebarCategory(cat) {
            // Update UI
            const buttons = document.querySelectorAll('.sidebar-cat-btn');
            buttons.forEach(btn => {
                if (btn.id === `btn-cat-${cat}`) {
                    btn.classList.add('bg-moss', 'text-white', 'shadow-md', 'font-bold');
                    btn.classList.remove('text-bark', 'hover:bg-cream/50', 'font-medium');
                    const spanCount = btn.querySelector('span:last-child');
                    if (spanCount) {
                        spanCount.classList.remove('text-tan');
                        spanCount.classList.add('opacity-60');
                    }
                } else {
                    btn.classList.remove('bg-moss', 'text-white', 'shadow-md', 'font-bold');
                    btn.classList.add('text-bark', 'hover:bg-cream/50', 'font-medium');
                    const spanCount = btn.querySelector('span:last-child');
                    if (spanCount && spanCount.classList.contains('opacity-60')) {
                        spanCount.classList.remove('opacity-60');
                        spanCount.classList.add('text-tan');
                    }
                }
            });

            filterSelect.value = cat;
            filterItems();
        }

        function filterItems() {
            const query = searchInput.value.toLowerCase();
            const selectVal = filterSelect.value.toLowerCase();

            let visibleCount = 0;
            cards.forEach(card => {
                const title = card.querySelector('.font-display').textContent.toLowerCase();
                const desc = card.querySelector('p').textContent.toLowerCase();
                const category = card.dataset.category || '';
                const seasonsAttr = card.dataset.saison || '';

                const matchSearch = title.includes(query) || desc.includes(query);
                const matchSelect = selectVal === 'all' || category === selectVal;
                
                let matchSeason = false;
                if (activeSeason === 'all') {
                    matchSeason = true;
                } else {
                    const cardSeasons = seasonsAttr.split(',').map(s => s.trim().toLowerCase());
                    matchSeason = cardSeasons.includes(activeSeason.toLowerCase());
                }

                const isVisible = matchSearch && matchSelect && matchSeason;
                card.classList.toggle('hidden', !isVisible);
                if (isVisible) visibleCount++;
            });
            itemCount.textContent = visibleCount;
        }

        if (searchInput) searchInput.addEventListener('input', filterItems);
        if (filterSelect) filterSelect.addEventListener('change', filterItems);

        // ── Modal logic Web ──
        const modalOverlay = document.getElementById('modal-overlay');

        function openModal(id) {
            const modal = document.getElementById(id);
            modalOverlay.classList.remove('hidden');
            setTimeout(() => modalOverlay.classList.add('opacity-100'), 10);
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('opacity-100', 'scale-100');
                modal.classList.remove('scale-95');
            }, 50);
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('opacity-100', 'scale-100');
            modal.classList.add('scale-95');
            modalOverlay.classList.remove('opacity-100');
            setTimeout(() => {
                modal.classList.add('hidden');
                modalOverlay.classList.add('hidden');
            }, 300);
        }

        if (modalOverlay) modalOverlay.addEventListener('click', () => closeModal('modal-details'));

        function openDetailsModal(button) {
            const card = button.closest('.clothing-card');
            if (!card) return;

            const nom = card.dataset.nom || 'Sans nom';
            const category = card.dataset.category || 'Non spécifiée';
            const saison = card.dataset.displaySaison || 'Toutes saisons';
            const couleur = card.dataset.couleur || 'Non spécifiée';
            const style = card.dataset.style || 'Non spécifié';
            const image = card.dataset.image;
            const emoji = card.dataset.emoji || '👗';

            // Set content
            document.getElementById('details-nom-display').textContent = nom;
            document.getElementById('details-category-display').textContent = category;
            document.getElementById('details-saison-display').textContent = saison;
            document.getElementById('details-couleur-display').textContent = couleur;
            document.getElementById('details-style-display').textContent = style;

            const imgEl = document.getElementById('details-image-display');
            const emojiEl = document.getElementById('details-emoji-display');

            if (image) {
                imgEl.src = image;
                imgEl.classList.remove('hidden');
                emojiEl.classList.add('hidden');
            } else {
                imgEl.classList.add('hidden');
                emojiEl.textContent = emoji;
                emojiEl.classList.remove('hidden');
            }

            openModal('modal-details');
        }
    </script>
</body>
</html>