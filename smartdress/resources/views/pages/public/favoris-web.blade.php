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
                <a href="{{ route('contact') }}" class="sd-navlink">Contact</a>
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
                    $currentCategorie = request('categorie');
                    $totalFavoris = $favoris->count();
                @endphp

                <a href="{{ route('favoris') }}"
                    class="flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ !$currentCategorie ? 'bg-moss text-white' : 'hover:bg-cream/50 text-bark' }}">
                    <span class="text-sm font-medium">Tout</span>
                    <span class="text-xs font-bold {{ !$currentCategorie ? 'opacity-80' : 'text-tan' }}">{{ $totalFavoris }}</span>
                </a>

                @foreach($categories as $cat)
                    @php
                        $count = $favoris->filter(function($f) use ($cat) {
                            return $f->vetement && $f->vetement->categorie === $cat;
                        })->count();
                    @endphp
                    <a href="{{ route('favoris', ['categorie' => $cat]) }}"
                        class="flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ $currentCategorie === $cat ? 'bg-moss text-white' : 'hover:bg-cream/50 text-bark' }}">
                        <span class="text-sm font-medium capitalize">{{ ucfirst($cat) }}</span>
                        <span class="text-xs font-bold {{ $currentCategorie === $cat ? 'opacity-80' : 'text-tan' }}">{{ $count }}</span>
                    </a>
                @endforeach
            </div>

            <!-- Saisons -->
            <div class="bg-white rounded-[2rem] shadow-xl shadow-bark/5 border border-tan/10 p-6 space-y-3">
                <h3 class="text-[10px] font-bold text-tan uppercase tracking-widest mb-4">Saisons</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach(['Hiver', 'Printemps', 'Été', 'Automne'] as $saison)
                        <span class="px-3 py-1.5 bg-cream/50 text-bark text-xs font-medium rounded-full border border-tan/10 cursor-pointer hover:bg-moss hover:text-white transition-all">
                            {{ $saison }}
                        </span>
                    @endforeach
                </div>
            </div>


        </aside>

        <!-- Contenu principal -->
        <section class="flex-1">

            <!-- Header + Search -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-4xl font-display font-medium text-bark italic">Mes <span class="text-moss">Favoris</span></h1>
                    <p class="text-sm text-tan mt-1">Affichage de {{ $favoris->count() }} articles</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-tan absolute left-4 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" placeholder="Rechercher un article..." 
                            class="pl-11 pr-5 py-3 bg-white border border-tan/10 rounded-2xl text-sm focus:border-moss outline-none transition-all w-64">
                    </div>
                    <select class="px-5 py-3 bg-white border border-tan/10 rounded-2xl text-sm text-bark focus:border-moss outline-none transition-all">
                        <option>Toutes catégories</option>
                        <option>Hauts</option>
                        <option>Bas</option>
                        <option>Chaussures</option>
                        <option>Accessoires</option>
                    </select>
                </div>
            </div>

            <!-- Grille des favoris -->
            @if($favoris->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($favoris as $favori)
                        @if($favori->vetement)
                            @php $vetement = $favori->vetement; @endphp
                            <div class="bg-white rounded-[2rem] border border-tan/10 shadow-lg shadow-bark/5 overflow-hidden group hover:shadow-xl hover:border-moss/30 transition-all duration-300 relative">

                                <!-- Bouton retirer des favoris -->
                                <form action="{{ route('favoris-api.destroy', $favori->id) }}" method="POST" class="absolute top-3 right-3 z-10">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 bg-white/90 rounded-full flex items-center justify-center shadow-md hover:bg-red-50 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-400 fill-red-400" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                </form>

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
                                        {{ ucfirst($vetement->categorie) }} / {{ $vetement->saison ?? 'Sans saison' }}
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
        <div class="fixed bottom-5 right-5 z-[100] flex flex-col gap-3 max-w-sm pointer-events-none">
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

</body>
</html>