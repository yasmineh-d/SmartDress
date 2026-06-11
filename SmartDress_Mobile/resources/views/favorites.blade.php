@extends('layouts.mobile', ['title' => 'SmartDress - Mes Favoris'])

@push('x-data-state')
    favoris: [],
    loading: true,

    async init() {
        const token = localStorage.getItem('auth_token');
        if (!token) {
            window.location.href = '{{ route("login") }}';
            return;
        }
        try {
            const res = await fetch(window.API_BASE + '/api/favoris', {
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
            // Filtrer pour ne garder que les vêtements favoris (vetement_id !== null)
            this.favoris = (json.data || json).filter(f => f.vetement_id !== null);
            this.loading = false;
        } catch (err) {
            console.error(err);
            this.loading = false;
        }
    },

    async removeFavorite(id) {
        const token = localStorage.getItem('auth_token');
        try {
            const res = await fetch(`${window.API_BASE}/api/favoris/${id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });
            if (res.ok) {
                this.favoris = this.favoris.filter(f => f.id !== id);
            }
        } catch (err) {
            console.error(err);
        }
    }
@endpush

@section('content')
    <h1 class="text-4xl font-display font-medium italic text-bark pb-4">Mes Favoris</h1>
    
    <!-- Favoris Grid -->
    <div class="grid grid-cols-2 gap-4">
        <template x-if="loading">
            <div class="col-span-2 py-20 flex justify-center">
                <svg class="animate-spin h-8 w-8 text-moss" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </template>

        <template x-for="fav in favoris" :key="fav.id">
            <div class="clothing-card group bg-white p-2.5 rounded-[2.5rem] border border-tan/10 shadow-xl shadow-bark/5 hover:-translate-y-1 transition-all duration-300">
                <div class="aspect-[4/5] bg-cream/30 rounded-[2rem] flex items-center justify-center relative overflow-hidden transition-colors group-hover:bg-cream/50">
                    <!-- Image -->
                    <template x-if="fav.vetement && fav.vetement.photos && fav.vetement.photos.length > 0">
                        <img :src="window.API_BASE + '/storage/' + fav.vetement.photos[0].url" class="w-full h-full object-contain p-2 zoom-img transition-transform duration-500">
                    </template>
                    <template x-if="!fav.vetement || !fav.vetement.photos || fav.vetement.photos.length === 0">
                        <span class="text-4xl zoom-img transition-transform duration-500" x-text="fav.vetement && fav.vetement.categorie.toLowerCase().includes('haut') ? '👕' : (fav.vetement && fav.vetement.categorie.toLowerCase().includes('bas') ? '👖' : (fav.vetement && fav.vetement.categorie.toLowerCase().includes('chauss') ? '👟' : '🧥'))"></span>
                    </template>
                    <!-- Heart button (always red since it's a favorite) -->
                    <button @click.stop="removeFavorite(fav.id)" class="absolute top-3 right-3 w-8 h-8 bg-white/80 backdrop-blur-md rounded-full flex items-center justify-center text-red-500 hover:text-red-300 transition-colors shadow-sm z-10">
                        <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>
                <div class="p-4 space-y-1" x-if="fav.vetement">
                    <p class="text-[10px] font-bold text-tan uppercase tracking-widest" x-text="fav.vetement.categorie"></p>
                    <h4 class="text-base font-display font-medium text-bark italic truncate" x-text="fav.vetement.nom"></h4>
                </div>
            </div>
        </template>

        <template x-if="!loading && favoris.length === 0">
            <div class="col-span-2 py-20 text-center space-y-6">
                <div class="w-24 h-24 bg-cream rounded-full flex items-center justify-center text-4xl mx-auto shadow-inner border border-tan/10">⭐</div>
                <div class="space-y-2">
                    <h2 class="text-xl font-display font-medium text-bark">Aucun favori pour le moment</h2>
                    <p class="text-sm text-tan max-w-[200px] mx-auto leading-relaxed italic">Cliquez sur le coeur ❤ d'un vêtement pour l'ajouter ici.</p>
                </div>
                <a href="{{ route('wardrobe') }}" class="inline-block px-10 py-4 bg-bark text-white rounded-full text-[10px] font-bold uppercase tracking-[0.2em] shadow-xl shadow-bark/20 hover:bg-moss transition-all hover:scale-105">Parcourir ma garde-robe</a>
            </div>
        </template>
    </div>
@endsection
