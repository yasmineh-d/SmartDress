@extends('layouts.mobile', ['title' => 'SmartDress - Mon Profil'])

@section('content')
    <h1 class="text-4xl font-display font-medium italic text-bark pb-4">Mon Profil</h1>
    
    <div class="bg-white rounded-[2.5rem] p-8 text-center space-y-6 border border-tan/10 shadow-sm">
        <div class="w-32 h-32 rounded-full bg-gradient-to-tr from-tan to-moss p-[4px] mx-auto">
            <div class="w-full h-full bg-white rounded-full flex items-center justify-center overflow-hidden">
                <img src="https://ui-avatars.com/api/?name=User&background=889063&color=fff&size=200" alt="Avatar large">
            </div>
        </div>
        <div class="space-y-1">
            <h2 class="text-2xl font-display font-medium italic text-bark">{{ auth()->user()->name ?? 'Yasmine' }}</h2>
            <p class="text-[10px] font-bold text-tan uppercase tracking-widest">{{ auth()->user()->email ?? 'yasmine@example.com' }}</p>
        </div>
        <div class="px-6 py-3 bg-cream/30 border border-tan/10 rounded-2xl flex items-center justify-center gap-4 text-xs font-bold text-moss uppercase tracking-widest italic decoration-moss underline underline-offset-4">
             Modifier le profil
        </div>
    </div>

    <nav class="space-y-4">
        <div class="p-6 bg-white rounded-[2rem] border border-tan/10 flex items-center justify-between hover:bg-cream/50 transition-colors">
            <div class="flex items-center gap-4">
                <span class="text-xl">📊</span>
                <span class="text-[11px] font-bold text-tan uppercase tracking-widest">Statistiques Style</span>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-tan" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
            </svg>
        </div>
        <div class="p-6 bg-white rounded-[2rem] border border-tan/10 flex items-center justify-between hover:bg-cream/50 transition-colors">
            <div class="flex items-center gap-4">
                <span class="text-xl">⚙️</span>
                <span class="text-[11px] font-bold text-tan uppercase tracking-widest">Paramètres</span>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-tan" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
            </svg>
        </div>
    </nav>
@endsection
