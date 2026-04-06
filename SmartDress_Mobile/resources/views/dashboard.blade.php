@extends('layouts.mobile', ['title' => 'SmartDress - Tableau de Bord'])

@push('x-data-state')
    vetements: [],
    suggestion: { top: null, bottom: null, title: 'Casual Moderne' },
    weather: { temp: '--', city: 'Casablanca', status: 'Chargement...', icon: '⛅' },
    loading: true,
    error: null,

    async init() {
        this.fetchWeather();
        try {
            const res = await fetch('http://10.0.2.2:8000/api/vetements');
            if (!res.ok) throw new Error('Erreur HTTP: ' + res.status);
            const json = await res.json();
            this.vetements = json.data || json;
            this.generateSuggestion();
            this.loading = false;
        } catch (err) {
            console.error(err);
            this.error = 'Erreur API : ' + err.message;
            this.loading = false;
        }
    },

    async fetchWeather() {
        try {
            const res = await fetch('https://wttr.in/Casablanca?format=j1');
            const data = await res.json();
            const current = data.current_condition[0];
            this.weather.temp = current.temp_C;
            this.weather.status = current.weatherDesc[0].value; 
            this.weather.city = data.nearest_area[0].areaName[0].value;
            
            const code = current.weatherCode;
            if (code <= 113) this.weather.icon = '☀️';
            else if (code <= 119) this.weather.icon = '⛅';
            else if (code <= 143) this.weather.icon = '🌫️';
            else if (code <= 200) this.weather.icon = '⛈️';
            else if (code <= 299) this.weather.icon = '🌦️';
            else this.weather.icon = '⛅';
        } catch (e) {
            console.warn('Erreur Météo API');
            this.weather.status = 'Ensoleillé';
            this.weather.temp = 24;
        }
    },

    generateSuggestion() {
        if (this.vetements.length === 0) return;

        const temp = parseFloat(this.weather.temp) || 20;
        const isHot = temp >= 22;
        const isCold = temp <= 16;

        // Filtrage des Hauts (Tops) selon la météo
        let tops = this.vetements.filter(v => v.categorie.toLowerCase().includes('haut'));
        if (isHot && tops.length > 0) {
            // On essaie de retirer les trucs trop chauds
            const lightTops = tops.filter(v => !v.nom.toLowerCase().match(/manteau|veste|pull|sweat|chaud|laine/));
            if (lightTops.length > 0) tops = lightTops;
        } else if (isCold && tops.length > 0) {
            // On privilégie les trucs chauds
            const warmTops = tops.filter(v => v.nom.toLowerCase().match(/manteau|veste|pull|sweat|chaud|laine/));
            if (warmTops.length > 0) tops = warmTops;
        }

        // Filtrage des Bas (Bottoms)
        let bottoms = this.vetements.filter(v => v.categorie.toLowerCase().includes('bas'));
        if (isHot && bottoms.length > 0) {
            // On privilégie shorts / jupes si dispo
            const lightBottoms = bottoms.filter(v => v.nom.toLowerCase().match(/short|jupe|léger/));
            if (lightBottoms.length > 0) bottoms = lightBottoms;
        }

        // Sélection aléatoire parmi les candidats filtrés
        this.suggestion.top = tops.length > 0 ? tops[Math.floor(Math.random() * tops.length)] : null;
        this.suggestion.bottom = bottoms.length > 0 ? bottoms[Math.floor(Math.random() * bottoms.length)] : null;
        
        // Titre dynamique selon la météo
        let titles = ['Casual Moderne', 'Tenue du Jour', 'Look Élégant', 'Style Minimaliste'];
        if (isHot) titles = ['Look Estival', 'Option Légère', 'Tenue d\'Été fraîche'];
        if (isCold) titles = ['Style Hivernal', 'Tenue Bien au Chaud', 'Look Cocooning'];

        this.suggestion.title = titles[Math.floor(Math.random() * titles.length)];
    }
@endpush

@section('content')
    <!-- Weather Widget -->
    <div class="bg-white/70 backdrop-blur-xl p-6 rounded-[2rem] shadow-sm border border-tan/10 flex items-center gap-5 translate-y-0">
        <div class="w-14 h-14 bg-cream flex items-center justify-center rounded-2xl shadow-inner border border-tan/10 text-3xl" x-text="weather.icon">
            ⛅
        </div>
        <div>
            <p class="text-[10px] font-bold text-tan uppercase tracking-[0.2em]">Météo / <span x-text="weather.city">Casablanca</span></p>
            <p class="text-2xl font-display font-semibold text-bark">
                 <span x-text="weather.temp">--</span>°C <span
                    class="text-moss italic font-medium ml-2" x-text="weather.status">Chargement...</span></p>
        </div>
    </div>

    <!-- Suggestion Card (With Real API Data) -->
    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-bark/5 overflow-hidden border border-tan/10">
        <div class="relative h-96 bg-cream/50 flex items-center justify-center p-12">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(207,187,153,0.1)_0%,transparent_70%)]"></div>
            <div class="absolute top-6 left-6 z-20">
                <span class="px-4 py-1.5 bg-moss text-white text-[10px] font-bold rounded-full shadow-lg shadow-moss/20 tracking-wider uppercase">Suggestion IA</span>
            </div>

            <!-- Loader while fetching -->
            <div x-show="loading" class="flex flex-col items-center gap-3">
                <svg class="animate-spin h-10 w-10 text-moss" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-xs font-bold text-tan uppercase tracking-widest">Calcul du look...</span>
            </div>

            <!-- Error state -->
            <div x-show="error" x-cloak class="flex flex-col items-center text-center p-4">
                 <span class="text-3xl mb-2">❌</span>
                 <span class="text-xs font-bold text-red-400 uppercase" x-text="error"></span>
            </div>

            <!-- Tenue Visuelle (Dynamically Populated) -->
            <div x-show="!loading && !error" x-cloak class="relative flex flex-col items-center gap-6">
                <!-- Top -->
                <div class="w-40 h-40 bg-white rounded-[2rem] border-4 border-white shadow-sm flex items-center justify-center flex-col transition-transform hover:scale-105 overflow-hidden relative">
                     <template x-if="suggestion.top && suggestion.top.image">
                         <img :src="suggestion.top.image" class="w-full h-full object-cover">
                     </template>
                     <template x-if="!suggestion.top || !suggestion.top.image">
                         <span class="text-4xl mb-2">👕</span>
                     </template>
                     <div class="absolute bottom-3 text-[9px] font-bold text-tan uppercase tracking-widest" 
                          x-text="suggestion.top ? suggestion.top.nom : 'Pas de haut trouvé'"></div>
                </div>
                <!-- Bottom -->
                <div class="w-44 h-52 bg-bone/30 rounded-[2rem] border-4 border-white shadow-sm flex items-center justify-center flex-col transition-transform hover:scale-105 overflow-hidden relative">
                    <template x-if="suggestion.bottom && suggestion.bottom.image">
                        <img :src="suggestion.bottom.image" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!suggestion.bottom || !suggestion.bottom.image">
                        <span class="text-4xl mb-2">👖</span>
                    </template>
                    <div class="absolute bottom-3 text-[9px] font-bold text-deeptan uppercase tracking-widest"
                         x-text="suggestion.bottom ? suggestion.bottom.nom : 'Pas de bas trouvé'"></div>
                </div>
            </div>
        </div>

        <div class="p-10 space-y-8">
            <div class="space-y-3">
                <h2 class="text-3xl font-display font-medium text-bark leading-tight italic" x-text="suggestion.title"></h2>
                <p class="text-bark/60 leading-relaxed font-light">Cette tenue est parfaite pour votre planning d'aujourd'hui. Basée sur votre inventaire réel.</p>
            </div>

            <div class="flex flex-col gap-4">
                <button class="w-full py-5 bg-moss text-white font-body font-medium text-xs tracking-[0.2em] uppercase rounded-full shadow-xl shadow-moss/20 hover:bg-bark transition-all active:scale-[0.98]">
                    Valider cette tenue
                </button>
                <button @click="generateSuggestion()" 
                        class="w-full py-5 text-tan hover:text-bark font-body font-bold uppercase tracking-[0.2em] rounded-2xl hover:bg-cream/50 transition-all flex items-center justify-center gap-3 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:rotate-180 transition-transform duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Générer un autre look
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Navigation -->
    <div class="grid grid-cols-2 gap-4">
        <a href="{{ route('wardrobe') }}" class="p-6 bg-white rounded-[2rem] border border-tan/10 flex flex-col items-center gap-3 hover:bg-cream/30 transition-all group">
            <div class="w-12 h-12 bg-cream text-tan rounded-xl flex items-center justify-center text-2xl shadow-inner border border-tan/5 group-hover:bg-white transition-colors">🧥</div>
            <span class="text-[10px] font-bold text-tan uppercase tracking-widest group-hover:text-bark transition-colors">Dressing</span>
        </a>
        <a href="{{ route('favorites') }}" class="p-6 bg-white rounded-[2rem] border border-tan/10 flex flex-col items-center gap-3 hover:bg-cream/30 transition-all group">
            <div class="w-12 h-12 bg-cream text-moss rounded-xl flex items-center justify-center text-2xl shadow-inner border border-tan/5 group-hover:bg-white transition-colors">⭐</div>
            <span class="text-[10px] font-bold text-tan uppercase tracking-widest group-hover:text-bark transition-colors">Favoris</span>
        </a>
    </div>
@endsection
