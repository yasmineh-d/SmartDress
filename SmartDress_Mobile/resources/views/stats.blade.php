@extends('layouts.mobile', ['title' => 'SmartDress - Statistiques'])

@section('content')
    <h1 class="text-4xl font-display font-medium italic text-bark pb-4">Statistiques</h1>
    
    <div class="grid grid-cols-2 gap-4">
        <div class="p-8 bg-white rounded-[2rem] border border-tan/10 space-y-4">
            <span class="text-3xl">🧥</span>
            <div class="space-y-1">
                <p class="text-2xl font-display font-bold text-moss">24</p>
                <p class="text-[9px] font-bold text-tan uppercase tracking-widest">Articles</p>
            </div>
        </div>
        <div class="p-8 bg-white rounded-[2rem] border border-tan/10 space-y-4">
            <span class="text-3xl">👗</span>
            <div class="space-y-1">
                <p class="text-2xl font-display font-bold text-bark">18</p>
                <p class="text-[9px] font-bold text-tan uppercase tracking-widest">Tenues Créées</p>
            </div>
        </div>
    </div>

    <div class="p-8 bg-white rounded-[3rem] border border-tan/10 space-y-6">
        <h3 class="text-xl font-display font-medium text-bark italic">Top Catégories</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-tan uppercase tracking-widest">Hauts</span>
                <span class="text-xs font-bold text-moss uppercase tracking-widest">45%</span>
            </div>
            <div class="w-full bg-cream rounded-full h-2">
                <div class="bg-moss h-2 rounded-full w-[45%]"></div>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-tan uppercase tracking-widest">Bas</span>
                <span class="text-xs font-bold text-moss uppercase tracking-widest">30%</span>
            </div>
            <div class="w-full bg-cream rounded-full h-2">
                <div class="bg-moss h-2 rounded-full w-[30%]"></div>
            </div>
        </div>
    </div>
@endsection
