@extends('layouts.mobile', ['title' => 'SmartDress - Ma Garde-Robe'])

@push('x-data-state')
    vetements: [],
    favoris: [],
    loading: true,

    async init() {
        const token = localStorage.getItem('auth_token');
        if (!token) {
            window.location.href = '{{ route("login") }}';
            return;
        }
        try {
            // Récupérer les vêtements
            const res = await fetch(window.API_BASE + '/api/vetements', {
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });
            if (!res.ok) {
                if (res.status === 401) {
                    localStorage.removeItem('auth_token');
                    window.location.href = '{{ route("login") }}';
                    return;
                }
                throw new Error('Erreur HTTP: ' + res.status);
            }
            const json = await res.json();
            this.vetements = json.data || json;

            // Récupérer les favoris pour le statut du cœur
            const resFav = await fetch(window.API_BASE + '/api/favoris', {
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });
            if (resFav.ok) {
                const jsonFav = await resFav.json();
                this.favoris = jsonFav.data || jsonFav;
            }

            this.loading = false;
        } catch (err) {
            console.error(err);
            this.loading = false;
        }
    },

    isFavorite(itemId) {
        return this.favoris.some(f => f.vetement_id === itemId);
    },

    async toggleFavorite(itemId) {
        const token = localStorage.getItem('auth_token');
        const existing = this.favoris.find(f => f.vetement_id === itemId);
        
        try {
            if (existing) {
                // Retirer des favoris
                const res = await fetch(window.API_BASE + '/api/favoris/' + existing.id, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });
                if (res.ok) {
                    this.favoris = this.favoris.filter(f => f.vetement_id !== itemId);
                }
            } else {
                // Ajouter aux favoris
                const res = await fetch(window.API_BASE + '/api/favoris', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ vetement_id: itemId })
                });
                if (res.ok) {
                    const json = await res.json();
                    this.favoris.push(json.data);
                }
            }
        } catch (err) {
            console.error(err);
        }
    }
@endpush

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="text-4xl font-display font-medium italic text-bark">Ma Garde-Robe</h1>
        <button @click="modalAddOpen = true" class="w-12 h-12 bg-moss text-white rounded-2xl flex items-center justify-center shadow-lg hover:scale-105 transition-transform">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
        </button>
    </div>

    <!-- Category Tabs -->
    <div class="flex gap-2 overflow-x-auto pb-4 scrollbar-hide">
        <button class="px-6 py-3 bg-moss text-white rounded-full text-xs font-bold uppercase tracking-widest shrink-0">Tout</button>
        <button class="px-6 py-3 bg-white text-tan rounded-full text-xs font-bold uppercase tracking-widest shrink-0 border border-tan/10">Hauts</button>
        <button class="px-6 py-3 bg-white text-tan rounded-full text-xs font-bold uppercase tracking-widest shrink-0 border border-tan/10">Bas</button>
        <button class="px-6 py-3 bg-white text-tan rounded-full text-xs font-bold uppercase tracking-widest shrink-0 border border-tan/10">Chaussures</button>
    </div>

    <!-- Wardrobe Grid -->
    <div class="grid grid-cols-2 gap-4">
        <template x-if="loading">
            <div class="col-span-2 py-20 flex justify-center">
                <svg class="animate-spin h-8 w-8 text-moss" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </template>

        <template x-for="item in vetements" :key="item.id">
            <div class="clothing-card group bg-white p-2.5 rounded-[2.5rem] border border-tan/10 shadow-xl shadow-bark/5 hover:-translate-y-1 transition-all duration-300">
                <div class="aspect-[4/5] bg-cream/30 rounded-[2rem] flex items-center justify-center relative overflow-hidden transition-colors group-hover:bg-cream/50">
                    <template x-if="item.photos && item.photos.length > 0">
                        <img :src="window.API_BASE + '/storage/' + item.photos[0].url" class="w-full h-full object-contain p-2 zoom-img transition-transform duration-500">
                    </template>
                    <template x-if="!item.photos || item.photos.length === 0">
                        <span class="text-4xl zoom-img transition-transform duration-500" x-text="item.categorie.toLowerCase().includes('haut') ? '👕' : (item.categorie.toLowerCase().includes('bas') ? '👖' : (item.categorie.toLowerCase().includes('chauss') ? '👟' : '🧥'))"></span>
                    </template>
                    <button @click.stop="toggleFavorite(item.id)" 
                            class="absolute top-3 right-3 w-8 h-8 bg-white/80 backdrop-blur-md rounded-full flex items-center justify-center transition-colors shadow-sm z-10"
                            :class="isFavorite(item.id) ? 'text-red-500' : 'text-tan hover:text-red-500'">
                        <svg class="w-4 h-4" :fill="isFavorite(item.id) ? 'currentColor' : 'none'" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>
                <div class="p-4 space-y-1">
                    <p class="text-[10px] font-bold text-tan uppercase tracking-widest" x-text="item.categorie"></p>
                    <h4 class="text-base font-display font-medium text-bark italic truncate" x-text="item.nom"></h4>
                </div>
            </div>
        </template>

        <template x-if="!loading && vetements.length === 0">
            <div class="col-span-2 py-20 text-center space-y-4">
                <p class="text-tan italic">Votre garde-robe est vide</p>
                <button @click="modalAddOpen = true" class="text-sm font-bold text-moss uppercase tracking-widest decoration-moss underline underline-offset-4">Ajouter mon premier vêtement</button>
            </div>
        </template>
    </div>
@endsection
