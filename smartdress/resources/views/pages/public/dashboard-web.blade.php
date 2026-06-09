<!DOCTYPE html>
<html lang="fr text-slate-900">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDress - Tableau de Bord (Web)</title>
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
    <style>
        .clothing-card:hover .zoom-effect { transform: scale(1.1); }
    </style>
</head>

<body class="bg-offwhite font-body text-bark min-h-screen flex flex-col">

    <header id="navbar" class="sd-navbar scrolled !fixed !bg-white/90">
        <div class="max-w-screen-xl mx-auto px-6 lg:px-12 flex items-center h-full gap-12">
            <a href="{{ url("/") }}" class="sd-logo">Smart<span>Dress</span></a>
            
            <nav class="hidden lg:flex items-center gap-8">
                <a href="#" class="sd-navlink !opacity-100 !text-moss font-bold border-b-2 border-moss pb-1">Dashboard</a>
                <a href="{{ route("garde-robe") }}" class="sd-navlink">Garde-Robe</a>
                <a href="{{ route("favoris") }}" class="sd-navlink">Favoris</a>
                <a href="{{ route("profile") }}" class="sd-navlink">Profil</a>
            </nav>

            <div class="ml-auto hidden lg:flex items-center gap-3">
                @auth
                <div class="flex items-center gap-3">
                    <a href="{{ route('profile') }}"
                        class="flex items-center gap-2 px-4 py-2 bg-cream/50 rounded-full text-xs font-bold text-bark hover:bg-cream transition-all border border-tan/10">
                        <div
                            class="w-6 h-6 bg-tan rounded-full flex items-center justify-center text-[10px] text-white">
                            {{ auth()->user()->initials() }}</div>
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

    <div class="h-20"></div> <main class="flex-1 max-w-7xl w-full mx-auto p-8 grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <aside class="lg:col-span-4 space-y-8">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-bark/5 border border-tan/10 space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-tan uppercase tracking-[0.2em]">Météo locale</p>
                        <p class="text-sm font-medium text-bark">{{ $meteo['ville'] ?? 'Tanger' }}, MA</p>
                    </div>
                    <div class="w-16 h-16 bg-cream flex items-center justify-center rounded-2xl shadow-inner border border-tan/10 text-4xl">
                        ⛅
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-5xl font-display font-semibold text-bark">{{ $meteo['temperature'] ?? 24 }}°</span>
                    <span class="text-xl text-moss italic font-medium">{{ $meteo['icone'] ?? 'Ensoleillé' }}</span>
                </div>
                <p class="text-xs text-bark/60 leading-relaxed font-light">
                    Conditions idéales pour une tenue légère et respirante aujourd'hui.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-bark p-6 rounded-[2rem] text-white space-y-2">
                    <p class="text-[9px] font-bold opacity-60 uppercase tracking-widest">Articles</p>
                    <p class="text-3xl font-display italic">{{ $totalArticles ?? 42 }}</p>
                </div>
                <div class="bg-moss p-6 rounded-[2rem] text-white space-y-2">
                    <p class="text-[9px] font-bold opacity-60 uppercase tracking-widest">Favoris</p>
                    <p class="text-3xl font-display italic">{{ $totalFavoris ?? 12 }}</p>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="px-4 text-[10px] font-bold text-tan uppercase tracking-widest">Navigation Rapide</h3>
                <div class="grid grid-cols-1 gap-2">
                    <a href="{{ route("garde-robe") }}" class="flex items-center justify-between p-4 bg-white rounded-2xl border border-tan/10 hover:border-moss transition-all group">
                        <div class="flex items-center gap-4">
                            <span class="text-xl">🧥</span>
                            <span class="text-sm font-medium text-bark">Gérer mon dressing</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-tan group-hover:text-moss" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="{{ route('planning.index') }}" class="flex items-center justify-between p-4 bg-white rounded-2xl border border-tan/10 hover:border-moss transition-all group">
                        <div class="flex items-center gap-4">
                            <span class="text-xl">📅</span>
                            <span class="text-sm font-medium text-bark">Planning de la semaine</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-tan group-hover:text-moss" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="{{ route("favoris") }}" class="flex items-center justify-between p-4 bg-white rounded-2xl border border-tan/10 hover:border-moss transition-all group">
                        <div class="flex items-center gap-4">
                            <span class="text-xl">⭐</span>
                            <span class="text-sm font-medium text-bark">Mes Favoris</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-tan group-hover:text-moss" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </aside>

        <section class="lg:col-span-8">
            <div class="bg-white rounded-[3rem] shadow-2xl shadow-bark/5 overflow-hidden border border-tan/10 flex flex-col md:flex-row h-full">
                <div class="md:w-1/2 bg-cream/30 relative flex items-center justify-center p-12 min-h-[400px]">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(207,187,153,0.15)_0%,transparent_70%)]"></div>
                    
                    <div id="outfit-preview-container" class="relative flex flex-col items-center gap-8 scale-110 opacity-0 transition-opacity duration-150">
                        <div class="w-48 h-48 bg-white rounded-[2.5rem] border-4 border-white shadow-xl flex items-center justify-center flex-col transform -rotate-3 transition-all hover:rotate-0 hover:scale-105 overflow-hidden relative" id="top-box">
                            <img id="top-img" src="" class="absolute inset-0 w-full h-full object-contain p-2 hidden">
                            <span class="text-6xl mb-3 relative z-10" id="top-icon">👕</span>
                            <span class="text-[11px] font-bold text-tan uppercase tracking-widest relative z-10 bg-white/90 px-3 py-1 rounded-full shadow-sm mt-auto mb-2 text-center" id="top-name">T-Shirt Blanc</span>
                        </div>
                        <div class="w-52 h-60 bg-bone/20 rounded-[2.5rem] border-4 border-white shadow-xl flex items-center justify-center flex-col transform rotate-2 transition-all hover:rotate-0 hover:scale-105 overflow-hidden relative" id="bottom-box">
                            <img id="bottom-img" src="" class="absolute inset-0 w-full h-full object-contain p-2 hidden">
                            <span class="text-6xl mb-3 relative z-10" id="bottom-icon">👖</span>
                            <span class="text-[11px] font-bold text-deeptan uppercase tracking-widest relative z-10 bg-white/90 px-3 py-1 rounded-full shadow-sm mt-auto mb-2 text-center" id="bottom-name">Jean Slim Bleu</span>
                        </div>
                    </div>

                    <div class="absolute top-8 left-8">
                        <span class="px-6 py-2 bg-moss text-white text-[11px] font-bold rounded-full shadow-lg shadow-moss/20 tracking-[0.2em] uppercase">Suggestion IA</span>
                    </div>
                </div>

                <div class="md:w-1/2 p-12 flex flex-col justify-center space-y-10">
                    <div class="space-y-4">
                        <h2 class="text-5xl font-display font-medium text-bark leading-tight italic" id="outfit-title">Casual Moderne</h2>
                        <p class="text-bark/60 text-lg leading-relaxed font-light">
                            Un look épuré et intemporel. Le blanc apporte du frais tandis que le denim assure le confort. Parfait pour une journée de travail créative ou une sortie en ville.
                        </p>
                    </div>

                    <div class="space-y-4 pt-4">
                        <button id="btn-porter-ensemble" type="button" class="w-full py-6 bg-moss text-white font-body font-bold text-xs tracking-[0.25em] uppercase rounded-full shadow-2xl shadow-moss/30 hover:bg-bark hover:translate-y-[-4px] transition-all transform duration-300">
                            Porter cet ensemble
                        </button>
                        <button id="refresh-outfit" class="w-full py-5 text-tan hover:text-bark font-body font-bold uppercase tracking-[0.2em] rounded-2xl hover:bg-cream/50 transition-all flex items-center justify-center gap-3 group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:rotate-180 transition-transform duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Générer un autre look
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <button id="add-item-btn" class="fixed bottom-8 right-8 w-16 h-16 bg-moss text-white rounded-full shadow-2xl flex items-center justify-center hover:bg-bark hover:scale-110 active:scale-95 transition-all z-40 group">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 transition-transform group-hover:rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
        </svg>
    </button>

    <div id="modal-overlay" class="fixed inset-0 bg-bark/60 backdrop-blur-sm z-50 hidden opacity-0 transition-opacity duration-300"></div>

    <div id="modal-add" class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white rounded-[3rem] shadow-2xl z-[60] hidden opacity-0 scale-95 transition-all duration-300 w-full max-w-xl p-12">
        <div class="flex items-center justify-between mb-10">
            <div class="space-y-1">
                <h2 class="text-3xl font-display font-medium text-bark italic">Ajouter au <span class="text-moss">Dressing</span></h2>
                <p class="text-tan text-xs font-medium uppercase tracking-widest">Nouvel article</p>
            </div>
            <button onclick="closeModal('modal-add')" class="w-12 h-12 flex items-center justify-center bg-cream/50 rounded-2xl text-tan hover:text-bark hover:bg-cream transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form id="form-add-vetement" action="{{ route('vetements.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-10">
            @csrf

            <div class="space-y-4">
                <input type="file" id="item-photo-input" name="photo" class="hidden" accept="image/*">
                <div id="upload-zone" onclick="document.getElementById('item-photo-input').click()" 
                    class="aspect-square bg-cream/20 border-2 border-dashed border-tan/20 rounded-[2.5rem] flex flex-col items-center justify-center text-tan hover:bg-cream/40 transition-all cursor-pointer group overflow-hidden relative">
                    <div id="upload-placeholder" class="flex flex-col items-center justify-center">
                        <div class="w-20 h-20 bg-white rounded-3xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-moss" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-widest">Prendre une photo</span>
                        <p class="text-[9px] text-tan/60 mt-2 px-6 text-center">Glissez une image ou cliquez pour parcourir</p>
                    </div>
                    <img id="item-photo-preview" class="absolute inset-0 w-full h-full object-cover hidden" alt="Preview">
                </div>
            </div>

            <div class="flex flex-col justify-between py-2 space-y-6">
                <div class="space-y-4">
                    <div class="space-y-1.5">
                        <label class="px-2 text-[10px] font-bold text-tan uppercase tracking-widest">Nom de l'article</label>
                        <input type="text" name="nom" placeholder="Ex: Veste en cuir vintage" class="w-full px-5 py-4 bg-white border border-tan/10 rounded-2xl focus:border-moss outline-none transition-all font-medium placeholder:text-tan/30 text-sm">
                    </div>

                    <div class="space-y-1.5 relative">
                        <label class="px-2 text-[10px] font-bold text-tan uppercase tracking-widest">Catégorie</label>
                        <select name="categorie" class="w-full py-4 ps-5 pe-12 bg-white border border-tan/10 rounded-2xl text-sm font-medium focus:ring-1 focus:ring-moss appearance-none outline-none">
                            <option value="">Choisir...</option>
                            <option value="hauts">Hauts</option>
                            <option value="bas">Bas</option>
                            <option value="chaussures">Chaussures</option>
                            <option value="accessoires">Accessoires</option>
                        </select>
                        <div class="absolute top-[2.4rem] end-4 pointer-events-none">
                            <svg class="shrink-0 size-4 text-tan/60" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"></path><path d="m7 9 5-5 5 5"></path></svg>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="px-2 text-[10px] font-bold text-tan uppercase tracking-widest block">Saisons (Max 2)</label>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <label class="flex items-center gap-2 bg-cream/20 p-2.5 rounded-xl border border-tan/10 cursor-pointer hover:bg-cream/50 transition-colors">
                                <input type="checkbox" name="saison[]" value="printemps" class="saison-checkbox rounded text-moss focus:ring-moss border-tan/30 size-4">
                                <span>Printemps</span>
                            </label>
                            <label class="flex items-center gap-2 bg-cream/20 p-2.5 rounded-xl border border-tan/10 cursor-pointer hover:bg-cream/50 transition-colors">
                                <input type="checkbox" name="saison[]" value="ete" class="saison-checkbox rounded text-moss focus:ring-moss border-tan/30 size-4">
                                <span>Été</span>
                            </label>
                            <label class="flex items-center gap-2 bg-cream/20 p-2.5 rounded-xl border border-tan/10 cursor-pointer hover:bg-cream/50 transition-colors">
                                <input type="checkbox" name="saison[]" value="automne" class="saison-checkbox rounded text-moss focus:ring-moss border-tan/30 size-4">
                                <span>Automne</span>
                            </label>
                            <label class="flex items-center gap-2 bg-cream/20 p-2.5 rounded-xl border border-tan/10 cursor-pointer hover:bg-cream/50 transition-colors">
                                <input type="checkbox" name="saison[]" value="hiver" class="saison-checkbox rounded text-moss focus:ring-moss border-tan/30 size-4">
                                <span>Hiver</span>
                            </label>
                        </div>
                    </div>
                </div>

                <button id="save-item-btn" type="button" onclick="addItemToGrid()" class="w-full py-5 bg-moss text-white rounded-full text-[10px] font-bold uppercase tracking-[0.2em] shadow-xl shadow-moss/20 hover:bg-bark transition-all mt-4">
                    Ajouter au dressing
                </button>
            </div>
        </form>
    </div>

    <script>
        const userHauts = @json($hauts);
        const userBas = @json($bas);
        const currentMeteo = @json($meteo);
        const storageUrl = "{{ asset('storage') }}";

        const refreshBtn = document.getElementById('refresh-outfit');
        const porterBtn = document.getElementById('btn-porter-ensemble'); // Capturer le bouton porter ensemble
        const titleEl = document.getElementById('outfit-title');
        
        const topIcon = document.getElementById('top-icon');
        const topImg = document.getElementById('top-img');
        const topName = document.getElementById('top-name');
        
        const bottomIcon = document.getElementById('bottom-icon');
        const bottomImg = document.getElementById('bottom-img');
        const bottomName = document.getElementById('bottom-name');

        // Variables pour garder en mémoire les ID de la suggestion actuelle
        let currentTopId = null;
        let currentBottomId = null;

        // Logique IA de génération de look filtrée selon la météo et la saison
        function generateLook(forceRandom = false) {
            try {
                console.log("generateLook called with forceRandom =", forceRandom);
                // Récupération de la température PHP de Laravel directement dans le JS
                const temp = {{ $meteo['temperature'] ?? 22 }};
                console.log("Current temp:", temp);
                
                // Détermination de la saison cible (avec la bonne casse et accents)
                let saisonCible = 'Printemps';
                if (temp > 25) saisonCible = 'Été';
                else if (temp < 16) saisonCible = 'Hiver';
                else if (temp >= 16 && temp <= 21) saisonCible = 'Automne';
                console.log("Target season:", saisonCible);

                // Filtrage selon la saison
                let hautsFiltres = userHauts.filter(h => {
                    // Supporte si saison est un tableau ou une chaîne
                    const saison = Array.isArray(h.saison) ? h.saison.join(' ') : (h.saison || '');
                    return saison.includes(saisonCible) || saison.includes('Toute saison');
                });
                
                let basFiltres = userBas.filter(b => {
                    const saison = Array.isArray(b.saison) ? b.saison.join(' ') : (b.saison || '');
                    return saison.includes(saisonCible) || saison.includes('Toute saison');
                });
                console.log("Filtered hauts count:", hautsFiltres.length);
                console.log("Filtered bas count:", basFiltres.length);

                // Fallback si aucun vêtement ne correspond à la météo
                if (hautsFiltres.length === 0) {
                    console.log("Fallback to all hauts");
                    hautsFiltres = userHauts;
                }
                if (basFiltres.length === 0) {
                    console.log("Fallback to all bas");
                    basFiltres = userBas;
                }

                if (hautsFiltres.length > 0 && basFiltres.length > 0) {
                    let randomHaut;
                    let randomBas;

                    // Si on ne force pas le changement ET qu'un look est déjà sauvegardé
                    if (!forceRandom && localStorage.getItem('smartdress_top_id') && localStorage.getItem('smartdress_bottom_id')) {
                        const savedTopId = parseInt(localStorage.getItem('smartdress_top_id'));
                        const savedBottomId = parseInt(localStorage.getItem('smartdress_bottom_id'));
                        console.log("Loading saved outfit from localStorage:", savedTopId, savedBottomId);

                        randomHaut = userHauts.find(h => h.id === savedTopId) || hautsFiltres[0];
                        randomBas = userBas.find(b => b.id === savedBottomId) || basFiltres[0];
                    } else {
                        // Choix aléatoire
                        console.log("Choosing a random outfit...");
                        randomHaut = hautsFiltres[Math.floor(Math.random() * hautsFiltres.length)];
                        randomBas = basFiltres[Math.floor(Math.random() * basFiltres.length)];

                        // Sauvegarde pour le prochain rafraîchissement
                        localStorage.setItem('smartdress_top_id', randomHaut.id);
                        localStorage.setItem('smartdress_bottom_id', randomBas.id);
                        console.log("Saved new outfit to localStorage:", randomHaut.id, randomBas.id);
                    }
                    
                    // Mise à jour des variables globales pour le bouton "Porter"
                    currentTopId = randomHaut.id;
                    currentBottomId = randomBas.id;

                    const titles = ["Casual Moderne", "Mix & Match", "Tenue du Jour", "Look Confort", "Élégance Simple"];
                    titleEl.textContent = titles[Math.floor(Math.random() * titles.length)];
                    
                    topName.textContent = randomHaut.nom;
                    if (randomHaut.photos && randomHaut.photos.length > 0) {
                        topImg.src = storageUrl + "/" + randomHaut.photos[0].url;
                        topImg.classList.remove('hidden');
                        topIcon.classList.add('hidden');
                    } else {
                        topImg.classList.add('hidden');
                        topIcon.classList.remove('hidden');
                    }

                    bottomName.textContent = randomBas.nom;
                    if (randomBas.photos && randomBas.photos.length > 0) {
                        bottomImg.src = storageUrl + "/" + randomBas.photos[0].url;
                        bottomImg.classList.remove('hidden');
                        bottomIcon.classList.add('hidden');
                    } else {
                        bottomImg.classList.add('hidden');
                        bottomIcon.classList.remove('hidden');
                    }
                } else {
                    console.log("Not enough garments to generate a look.");
                    titleEl.textContent = "Besoin de plus de vêtements !";
                    topName.textContent = "Ajoutez un haut";
                    bottomName.textContent = "Ajoutez un bas";
                }
                const previewContainer = document.getElementById('outfit-preview-container');
                if (previewContainer) {
                    previewContainer.classList.remove('opacity-0');
                }
            } catch (err) {
                console.error("Error in generateLook:", err);
                const previewContainer = document.getElementById('outfit-preview-container');
                if (previewContainer) {
                    previewContainer.classList.remove('opacity-0');
                }
            }
        }

        // Événement clic : Enregistrer l'ensemble au planning via Fetch API
        if (porterBtn) {
            porterBtn.addEventListener('click', () => {
                if (!currentTopId || !currentBottomId) {
                    alert("Aucun ensemble n'a été généré.");
                    return;
                }

                fetch("{{ route('planning.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        top_id: currentTopId,
                        bottom_id: currentBottomId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("✨ Succès : " + data.message);
                    } else {
                        alert("Erreur lors de l'enregistrement.");
                    }
                })
                .catch(error => console.error("Erreur:", error));
            });
        }

        refreshBtn.addEventListener('click', () => {
            refreshBtn.classList.add('opacity-50', 'pointer-events-none');
            setTimeout(() => {
                generateLook(true); // Force un changement
                refreshBtn.classList.remove('opacity-50', 'pointer-events-none');
            }, 600);
        });

        generateLook(false); // Chargement immédiat sans forcer (utilise la mémoire)

        // Limitation stricte de cois des checkbox à 2 max
        document.querySelectorAll('.saison-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const checkedCount = document.querySelectorAll('.saison-checkbox:checked').length;
                if (checkedCount >= 2) {
                    document.querySelectorAll('.saison-checkbox:not(:checked)').forEach(el => {
                        el.disabled = true;
                        el.parentElement.classList.add('opacity-40', 'cursor-not-allowed');
                    });
                } else {
                    document.querySelectorAll('.saison-checkbox').forEach(el => {
                        el.disabled = false;
                        el.parentElement.classList.remove('opacity-40', 'cursor-not-allowed');
                    });
                }
            });
        });

        // Validation complète avant soumission
        function addItemToGrid() {
            const nameInput = document.querySelector('#modal-add input[name="nom"]');
            const categorySelect = document.querySelector('#modal-add select[name="categorie"]');
            const photoInput = document.getElementById('item-photo-input');
            const checkedSaisons = document.querySelectorAll('.saison-checkbox:checked');

            if (!nameInput.value) { alert("Veuillez remplir le nom de l'article."); return; }
            if (!categorySelect.value) { alert("Veuillez choisir une catégorie."); return; }
            if (!photoInput.files || photoInput.files.length === 0) { alert("Veuillez ajouter une photo."); return; }
            if (checkedSaisons.length === 0) { alert("Veuillez choisir au moins une saison."); return; }

            document.getElementById('form-add-vetement').submit();
        }

        // ── Modal logic ──
        const modalOverlay = document.getElementById('modal-overlay');
        const addItemBtn = document.getElementById('add-item-btn');

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

        if (addItemBtn) addItemBtn.addEventListener('click', () => openModal('modal-add'));
        if (modalOverlay) modalOverlay.addEventListener('click', () => closeModal('modal-add'));

        // ── Photo Upload Preview ──
        const photoInput = document.getElementById('item-photo-input');
        const photoPreview = document.getElementById('item-photo-preview');
        const uploadPlaceholder = document.getElementById('upload-placeholder');

        if (photoInput) {
            photoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        photoPreview.src = e.target.result;
                        photoPreview.classList.remove('hidden');
                        uploadPlaceholder.classList.add('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
    </script>

    @if ($errors->any() || session('success'))
        <div class="fixed bottom-28 right-5 z-[100] flex flex-col gap-3 max-w-sm pointer-events-none">
            @if (session('success'))
                <div class="pointer-events-auto p-4 rounded-3xl bg-moss/95 backdrop-blur-md text-white shadow-2xl border border-white/20 flex items-center gap-3 animate-bounce">
                    <span class="text-xl">✨</span>
                    <div>
                        <h5 class="font-bold text-xs uppercase tracking-wider text-cream">Succès</h5>
                        <p class="text-xs font-light opacity-90">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="pointer-events-auto p-4 rounded-3xl bg-bark/95 backdrop-blur-md text-white shadow-2xl border border-red-500/20 flex items-start gap-3">
                    <span class="text-xl text-red-400">⚠️</span>
                    <div>
                        <h5 class="font-bold text-xs uppercase tracking-wider text-red-300">Erreur</h5>
                        <ul class="text-xs font-light opacity-90 list-disc list-inside mt-1 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    @endif

</body>

</html>