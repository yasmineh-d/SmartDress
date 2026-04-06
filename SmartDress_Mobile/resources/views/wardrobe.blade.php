@extends('layouts.mobile', ['title' => 'SmartDress - Ma Garde-Robe'])

@push('x-data-state')
    vetements: [],
    loading: true,

    async init() {
        try {
            const res = await fetch('http://10.0.2.2:8000/api/vetements');
            const json = await res.json();
            this.vetements = json.data || json;
            this.loading = false;
        } catch (err) {
            console.error(err);
            this.loading = false;
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
            <div class="bg-white rounded-[2rem] overflow-hidden border border-tan/10 group">
                <div class="aspect-square bg-cream/30 flex items-center justify-center p-4 relative">
                    <template x-if="item.image">
                        <img :src="item.image" class="w-full h-full object-cover rounded-xl">
                    </template>
                    <template x-if="!item.image">
                        <span class="text-4xl" x-text="item.categorie.toLowerCase().includes('haut') ? '👕' : '👖'"></span>
                    </template>
                    <button class="absolute top-2 right-2 w-8 h-8 bg-white/80 backdrop-blur-md rounded-full flex items-center justify-center text-red-300 hover:text-red-500 transition-colors">
                        ❤
                    </button>
                </div>
                <div class="p-4">
                    <p class="text-[10px] font-bold text-moss uppercase tracking-widest" x-text="item.categorie"></p>
                    <p class="text-sm font-medium text-bark truncate" x-text="item.nom"></p>
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
