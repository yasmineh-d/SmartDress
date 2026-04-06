@extends('layouts.mobile', ['title' => 'SmartDress - Mes Favoris'])

@section('content')
    <h1 class="text-4xl font-display font-medium italic text-bark pb-4">Mes Favoris</h1>
    
    <div class="py-20 text-center space-y-6">
        <div class="w-24 h-24 bg-cream rounded-full flex items-center justify-center text-4xl mx-auto shadow-inner border border-tan/10">⭐</div>
        <div class="space-y-2">
            <h2 class="text-xl font-display font-medium text-bark">Aucun favori pour le moment</h2>
            <p class="text-sm text-tan max-w-[200px] mx-auto leading-relaxed italic">Cliquez sur le coeur ❤ d'un vêtement pour l'ajouter ici.</p>
        </div>
        <a href="{{ route('wardrobe') }}" class="inline-block px-10 py-4 bg-bark text-white rounded-full text-[10px] font-bold uppercase tracking-[0.2em] shadow-xl shadow-bark/20 hover:bg-moss transition-all hover:scale-105">Parcourir ma garde-robe</a>
    </div>
@endsection
