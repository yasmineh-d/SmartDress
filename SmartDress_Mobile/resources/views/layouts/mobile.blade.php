<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SmartDress' }}</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet" />

    <!-- Tailwind config -->
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
                    },
                }
            }
        }
    </script>
    <link rel="stylesheet" href="{{ asset('assets/css/charte.css') }}">
    <style>
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>

<body class="bg-bark font-body text-bark min-h-screen flex items-start sm:items-center justify-center p-0 sm:p-6 relative overflow-x-hidden"
    x-data="{ 
        mobileMenuOpen: false, 
        modalAddOpen: false,
        @stack('x-data-state')
    }">

    <!-- Background Flow Effect -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&q=80')] bg-cover bg-center blur-md scale-110 opacity-60"></div>
        <div class="absolute inset-0 bg-bark/30 mix-blend-multiply"></div>
    </div>

    <!-- Mobile Mockup Container -->
    <div class="w-full sm:max-w-md md:max-w-lg h-screen sm:h-auto sm:my-8 bg-offwhite sm:min-h-[90vh] sm:rounded-[3.5rem] shadow-2xl relative z-10 flex flex-col overflow-hidden sm:border-[8px] border-white/20">

        <!-- Off-canvas Menu (Sidebar Mobile) -->
        <div class="absolute inset-0 z-[100] transition-transform duration-500 ease-in-out pointer-events-none"
             :class="mobileMenuOpen ? 'translate-x-0' : 'translate-x-[-100%]'" x-cloak>
            <!-- Backdrop -->
            <div @click="mobileMenuOpen = false" 
                 class="absolute inset-0 bg-bark/60 backdrop-blur-sm transition-opacity duration-500"
                 :class="mobileMenuOpen ? 'opacity-100 pointer-events-auto' : 'opacity-0 pointer-events-none'"></div>
            
            <!-- Sidebar Content -->
            <div class="absolute inset-y-0 left-0 w-[80%] bg-offwhite shadow-2xl flex flex-col pointer-events-auto">
                <div class="p-8 border-b border-tan/10 flex items-center justify-between">
                    <div style="font-family: 'Cormorant Garamond', serif;" class="text-2xl tracking-tight select-none flex items-baseline">
                        <span style="font-weight: 400; color: #5C4A35;">Smart</span>
                        <span style="font-weight: 600; font-style: italic; color: #889063; margin-left: -0.02em;">Dress</span>
                    </div>
                    <button @click="mobileMenuOpen = false" class="w-10 h-10 flex items-center justify-center bg-cream/50 rounded-xl hover:bg-cream transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-tan" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <nav class="flex-1 p-8 space-y-4">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-4 p-4 {{ request()->routeIs('dashboard') ? 'bg-moss text-white shadow-lg shadow-moss/20' : 'hover:bg-cream/50' }} rounded-2xl transition-all group">
                        <span class="text-xl {{ !request()->routeIs('dashboard') ? 'group-hover:scale-110' : '' }} transition-transform">🏠</span>
                        <span class="text-[11px] font-bold {{ request()->routeIs('dashboard') ? 'uppercase' : 'text-tan group-hover:text-bark uppercase' }} tracking-widest">Tableau de Bord</span>
                    </a>
                    <a href="{{ route('wardrobe') }}" class="flex items-center gap-4 p-4 {{ request()->routeIs('wardrobe') ? 'bg-moss text-white shadow-lg shadow-moss/20' : 'hover:bg-cream/50' }} rounded-2xl transition-all group">
                        <span class="text-xl group-hover:scale-110 transition-transform">🧥</span>
                        <span class="text-[11px] font-bold {{ request()->routeIs('wardrobe') ? 'uppercase' : 'text-tan group-hover:text-bark uppercase' }} tracking-widest transition-colors">Ma Garde-Robe</span>
                    </a>
                    <a href="{{ route('favorites') }}" class="flex items-center gap-4 p-4 {{ request()->routeIs('favorites') ? 'bg-moss text-white shadow-lg shadow-moss/20' : 'hover:bg-cream/50' }} rounded-2xl transition-all group">
                        <span class="text-xl group-hover:scale-110 transition-transform">⭐</span>
                        <span class="text-[11px] font-bold {{ request()->routeIs('favorites') ? 'uppercase' : 'text-tan group-hover:text-bark uppercase' }} tracking-widest transition-colors">Mes Favoris</span>
                    </a>
                    <a href="{{ route('profile') }}" class="flex items-center gap-4 p-4 {{ request()->routeIs('profile') ? 'bg-moss text-white shadow-lg shadow-moss/20' : 'hover:bg-cream/50' }} rounded-2xl transition-all group">
                        <span class="text-xl group-hover:scale-110 transition-transform">👤</span>
                        <span class="text-[11px] font-bold {{ request()->routeIs('profile') ? 'uppercase' : 'text-tan group-hover:text-bark uppercase' }} tracking-widest transition-colors">Mon Profil</span>
                    </a>
                </nav>

                <div class="p-8 border-t border-tan/10">
                    <a href="{{ url('/') }}" class="flex items-center gap-4 p-4 text-red-400 hover:text-red-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="text-[11px] font-bold uppercase tracking-widest">Déconnexion</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Header / Top Bar -->
        <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-tan/10 px-6 py-4">
            <div class="max-w-full px-4 mx-auto flex items-center justify-between">
                <button @click="mobileMenuOpen = true" class="w-10 h-10 flex items-center justify-center bg-cream/50 rounded-xl hover:bg-cream transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-tan" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
                <div style="font-family: 'Cormorant Garamond', serif;" class="text-2xl tracking-tight select-none flex items-baseline">
                    <span style="font-weight: 400; color: #5C4A35;">Smart</span>
                    <span style="font-weight: 600; font-style: italic; color: #889063; margin-left: -0.02em;">Dress</span>
                </div>
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-tan to-moss p-[2px]">
                    <div class="w-full h-full bg-white rounded-[10px] flex items-center justify-center overflow-hidden">
                        <img src="https://ui-avatars.com/api/?name=User&background=889063&color=fff" alt="Avatar">
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-full mx-auto p-6 space-y-8 flex-1 overflow-y-auto pb-24">
            @yield('content')
        </main>

        <!-- Modal Overlay -->
        <div x-show="modalAddOpen" x-cloak
             x-transition:enter="transition opacity-100 duration-300"
             x-transition:leave="transition opacity-0 duration-300"
             class="fixed inset-0 bg-bark/60 backdrop-blur-sm z-[60]"
             @click="modalAddOpen = false"></div>

        <!-- Modal : Ajouter un vêtement -->
        <div x-show="modalAddOpen" x-cloak
             x-transition:enter="transition transform duration-500 ease-out"
             x-transition:enter-start="translate-y-full"
             x-transition:enter-end="translate-y-0"
             x-transition:leave="transition transform duration-500 ease-in"
             x-transition:leave-start="translate-y-0"
             x-transition:leave-end="translate-y-full"
             class="fixed inset-x-0 bottom-0 bg-white rounded-t-[2.5rem] shadow-2xl z-[70] w-full sm:max-w-md md:max-w-lg mx-auto p-10 space-y-8">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-display font-medium text-bark italic">Ajouter au dressing</h2>
                <button @click="modalAddOpen = false" class="text-tan hover:text-bark transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form class="space-y-6" @submit.prevent="modalAddOpen = false">
                <div class="flex justify-center">
                    <div class="w-24 h-24 bg-cream/30 border-2 border-dashed border-tan/20 rounded-3xl flex flex-col items-center justify-center text-tan hover:bg-cream/50 transition-colors cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-[9px] font-bold uppercase tracking-wider">Photo</span>
                    </div>
                </div>
                <div class="space-y-4">
                    <input type="text" placeholder="Nom de l'article (ex: Veste cuir)"
                        class="w-full px-5 py-4 bg-cream/20 border border-tan/10 rounded-2xl focus:border-moss outline-none transition-all font-medium placeholder:text-tan/40 text-sm placeholder:italic">
                    <select class="w-full px-5 py-4 bg-cream/20 border border-tan/10 rounded-2xl focus:border-moss outline-none transition-all font-medium text-sm text-bark/60 appearance-none">
                        <option value="">Choisir une catégorie...</option>
                        <option value="hauts">Hauts</option>
                        <option value="bas">Bas</option>
                        <option value="chaussures">Chaussures</option>
                    </select>
                </div>
                <button type="submit" class="w-full py-5 bg-bark text-white rounded-full text-[10px] font-bold uppercase tracking-[0.2em] shadow-xl shadow-bark/20 hover:bg-moss transition-all">
                    Ajouter l'article
                </button>
            </form>
        </div>

        <!-- Bottom Navigation Bar (Mobile Style) -->
        <nav class="sticky bottom-0 left-0 right-0 bg-white/95 backdrop-blur-xl border-t border-tan/10 px-8 py-4 flex justify-between items-center z-50 shadow-[0_-10px_40px_rgba(0,0,0,0.05)]">
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('dashboard') ? 'text-moss' : 'text-tan hover:text-bark' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                </svg>
            </a>
            <a href="{{ route('wardrobe') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('wardrobe') ? 'text-moss' : 'text-tan hover:text-bark' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </a>
            <div class="w-14 h-14 relative -top-8 border-4 border-white rounded-full bg-cream flex items-center justify-center shadow-lg">
                <button @click="modalAddOpen = true" class="w-10 h-10 bg-moss rounded-full flex items-center justify-center text-white shadow-md hover:scale-105 active:scale-95 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                    </svg>
                </button>
            </div>
            <a href="{{ route('stats') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('stats') ? 'text-moss' : 'text-tan hover:text-bark' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m12 4a2 2 0 100-4m0 4a2 2 0 110-4m-6 0a2 2 0 100 4m0-4a2 2 0 110 4" />
                </svg>
            </a>
            <a href="{{ route('profile') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('profile') ? 'text-moss' : 'text-tan hover:text-bark' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </a>
        </nav>
    </div> <!-- End Mobile Mockup Container -->

    @stack('scripts')
</body>
</html>
