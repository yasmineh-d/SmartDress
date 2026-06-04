<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDress - Mon Planning de la semaine</title>
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
    <link rel="stylesheet" href="{{ asset('assets/css/charte.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-landing.css') }}">
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
                <a href="{{ route('favoris') }}" class="sd-navlink">Favoris</a>
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

    <main class="flex-1 max-w-7xl w-full mx-auto p-8">

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
            <div>
                <h1 class="text-4xl font-display font-medium text-bark italic">Planning de la <span class="text-moss">Semaine</span></h1>
                <p class="text-sm text-tan mt-1">Organisez vos tenues et planifiez votre style au quotidien</p>
            </div>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3.5 bg-moss text-white rounded-full text-xs font-bold uppercase tracking-widest hover:bg-bark transition-all shadow-xl shadow-moss/10">
                ✨ Inspirer un ensemble
            </a>
        </div>

        <!-- Weekly Layout -->
        <div class="space-y-6">
            @foreach($semaine as $jour)
                @php
                    $estAujourd = $jour['estAujourd'];
                @endphp
                <div class="bg-white rounded-[2.5rem] border {{ $estAujourd ? 'border-moss shadow-xl shadow-moss/5 bg-moss/[0.01]' : 'border-tan/10 shadow-lg shadow-bark/5' }} overflow-hidden p-6 md:p-8 flex flex-col md:flex-row gap-6 items-center transition-all duration-300">
                    
                    <!-- Day Info -->
                    <div class="w-full md:w-48 shrink-0 flex flex-row md:flex-col items-center md:items-start justify-between md:justify-center gap-2 border-b md:border-b-0 md:border-r border-tan/10 pb-4 md:pb-0 md:pr-6">
                        <div>
                            <p class="text-xl font-display font-semibold italic text-bark {{ $estAujourd ? 'text-moss' : '' }}">
                                {{ $jour['label'] }}
                            </p>
                            <p class="text-xs text-tan font-medium">
                                {{ \Carbon\Carbon::parse($jour['date'])->format('d/m/Y') }}
                            </p>
                        </div>
                        @if($estAujourd)
                            <span class="px-3 py-1 bg-moss text-white text-[9px] font-bold uppercase tracking-wider rounded-full">Aujourd'hui</span>
                        @endif
                    </div>

                    <!-- Planned Outfits -->
                    <div class="flex-1 w-full">
                        @if($jour['tenues']->isEmpty())
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 py-3">
                                <div class="flex items-center gap-4 text-bark/50">
                                    <svg class="w-12 h-12 text-black fill-current" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M 195 150 C 180 120 170 80 180 50 C 200 40 230 60 256 90 C 282 60 312 40 332 50 C 342 80 332 120 317 150 Z" />
                                        <path d="M 195 150 Q 256 160 317 150 L 317 175 Q 256 185 195 175 Z" />
                                        <path d="M 195 175 Q 256 185 317 175 C 348 240 430 360 442 420 C 448 450 400 470 256 470 C 112 470 64 450 70 420 C 82 360 164 240 195 175 Z" />
                                        <path d="M 215 270 Q 180 350 125 435" stroke="white" stroke-width="8" stroke-linecap="round" fill="none" />
                                        <path d="M 297 270 Q 332 350 387 435" stroke="white" stroke-width="8" stroke-linecap="round" fill="none" />
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium">Aucune tenue planifiée</p>
                                        <p class="text-xs text-bark/40 font-light">Laissez parler votre créativité pour ce jour.</p>
                                    </div>
                                </div>
                                <a href="{{ route('dashboard') }}" class="px-4 py-2 border border-tan/20 hover:border-moss hover:bg-moss/5 text-bark/70 hover:text-moss text-xs font-semibold rounded-full transition-all">
                                    Choisir une tenue
                                </a>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($jour['tenues'] as $tenue)
                                    <div class="flex items-center justify-between bg-cream/10 border border-tan/5 rounded-2xl p-4 hover:bg-cream/20 transition-all group">
                                        <div class="flex items-center gap-6">
                                            <!-- Top Image / Placeholder -->
                                            <div class="flex items-center gap-2">
                                                <div class="w-16 h-16 bg-white border border-tan/10 rounded-2xl flex items-center justify-center overflow-hidden relative shadow-sm" title="Haut">
                                                    @if($tenue->top && $tenue->top->photos && $tenue->top->photos->count() > 0)
                                                        <img src="{{ asset('storage/' . $tenue->top->photos->first()->url) }}" class="w-full h-full object-cover">
                                                    @else
                                                        <span class="text-3xl">👕</span>
                                                    @endif
                                                    <span class="absolute bottom-1 right-1 text-[8px] bg-bark/60 text-white px-1.5 py-0.5 rounded font-bold uppercase">Haut</span>
                                                </div>

                                                <span class="text-tan font-light">&amp;</span>

                                                <!-- Bottom Image / Placeholder -->
                                                <div class="w-16 h-16 bg-white border border-tan/10 rounded-2xl flex items-center justify-center overflow-hidden relative shadow-sm" title="Bas">
                                                    @if($tenue->bottom && $tenue->bottom->photos && $tenue->bottom->photos->count() > 0)
                                                        <img src="{{ asset('storage/' . $tenue->bottom->photos->first()->url) }}" class="w-full h-full object-cover">
                                                    @else
                                                        <span class="text-3xl">👖</span>
                                                    @endif
                                                    <span class="absolute bottom-1 right-1 text-[8px] bg-bark/60 text-white px-1.5 py-0.5 rounded font-bold uppercase">Bas</span>
                                                </div>
                                            </div>

                                            <!-- Outfit Details -->
                                            <div>
                                                <p class="text-sm font-semibold text-bark">
                                                    {{ $tenue->top ? $tenue->top->nom : 'Haut supprimé' }}
                                                    <span class="text-tan font-normal"> + </span>
                                                    {{ $tenue->bottom ? $tenue->bottom->nom : 'Bas supprimé' }}
                                                </p>
                                                <p class="text-xs text-tan/80 font-light mt-1"> Ensemble planifié pour votre journée. </p>
                                            </div>
                                        </div>

                                        <!-- Delete Action -->
                                        <form action="{{ route('planning.destroy', $tenue->id) }}" method="POST" class="opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-10 h-10 bg-white border border-tan/10 rounded-2xl flex items-center justify-center text-tan hover:text-red-400 hover:bg-red-50 hover:border-red-100 shadow-sm transition-all" title="Retirer du planning">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
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
