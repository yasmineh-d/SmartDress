<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name', 'SmartDress') }} – Votre garde-robe intelligente</title>

    <!-- Tailwind CSS (via Vite/Internal) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet" />

    <!-- External styles copied from Maquettes -->
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}" />

    <!-- Tailwind config for theme tokens (since it's a direct port) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        tan: '#CFBB99',
                        bone: '#E5D7C4',
                        moss: '#889063',
                        deeptan: '#B8A07E',
                        cream: '#F5EEE4',
                        bark: '#5C4A35',
                        offwhite: '#FDFAF6',
                    },
                    fontFamily: {
                        display: ['"Cormorant Garamond"', 'serif'],
                        body: ['"DM Sans"', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>

<body class="font-body bg-offwhite text-bark overflow-x-hidden" 
    x-data="{ mobileMenuOpen: false, scrolled: false, isLoggedIn: {{ Auth::check() ? 'true' : 'false' }} }"
    @scroll.window="scrolled = (window.pageYOffset > 20)">

    <!-- NAVBAR -->
    <header id="navbar" class="sd-navbar" :class="{ 'scrolled': scrolled }">
        <div class="max-w-screen-xl mx-auto px-6 lg:px-12 flex items-center justify-between h-full">
            <a href="{{ url('/') }}" class="sd-logo">Smart<span>Dress</span></a>

            <nav class="hidden lg:flex items-center gap-8">
                <a href="#features" class="sd-navlink">Fonctionnalités</a>
                <a href="#how" class="sd-navlink">Comment ça marche</a>
                <a href="#trust" class="sd-navlink">Témoignages</a>
                <a href="#contact" class="sd-navlink">Contact</a>
            </nav>

            <div class="hidden lg:flex items-center gap-3">
                @guest
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="sd-btn-ghost">Se connecter</a>
                        <a href="{{ route('register') }}" class="sd-btn-primary">Commencer</a>
                    </div>
                @endguest
                @auth
                    <div class="flex items-center gap-3">
                        <a href="{{ url('/dashboard') }}" class="flex items-center gap-2 px-4 py-2 bg-cream/50 rounded-full text-xs font-bold text-bark hover:bg-cream transition-all border border-tan/10">
                            <div class="w-6 h-6 bg-tan rounded-full flex items-center justify-center text-[10px] text-white">
                                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                            </div>
                            Tableau de bord
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-xs font-bold text-tan hover:text-bark uppercase tracking-widest px-2 transition-all">Déconnexion</button>
                        </form>
                    </div>
                @endauth
            </div>

            <!-- Mobile hamburger -->
            <button type="button" class="lg:hidden sd-hamburger" @click="mobileMenuOpen = !mobileMenuOpen"
                :aria-expanded="mobileMenuOpen">
                <span class="sr-only">Menu</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 12h18M3 6h18M3 18h18" />
                    <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M6 18L18 6M6 6l12 12" style="display: none;" />
                </svg>
            </button>
        </div>

        <!-- Mobile menu -->
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            class="lg:hidden bg-offwhite border-t border-tan/30 shadow-xl" style="display: none;">
            <div class="px-6 py-4 flex flex-col gap-3">
                <a href="#features" class="sd-navlink" @click="mobileMenuOpen = false">Fonctionnalités</a>
                <a href="#how" class="sd-navlink" @click="mobileMenuOpen = false">Comment ça marche</a>
                <a href="#trust" class="sd-navlink" @click="mobileMenuOpen = false">Témoignages</a>
                <a href="#contact" class="sd-navlink" @click="mobileMenuOpen = false">Contact</a>
                <hr class="border-tan/30 my-1" />
                @guest
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('login') }}" class="sd-btn-ghost text-center" @click="mobileMenuOpen = false">Se connecter</a>
                        <a href="{{ route('register') }}" class="sd-btn-primary text-center" @click="mobileMenuOpen = false">Commencer gratuitement</a>
                    </div>
                @endguest
                @auth
                    <div class="flex flex-col gap-3">
                        <a href="{{ url('/dashboard') }}" class="sd-btn-ghost text-center" @click="mobileMenuOpen = false">Mon Profil</a>
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="sd-btn-primary text-center w-full">Déconnexion</button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- HERO -->
    <section class="sd-hero">
        <div class="sd-hero-left">
            <span class="sd-eyebrow">Votre stylist personnel · IA &amp; Météo</span>

            <h1 class="sd-hero-title">
                S'habiller<br>avec <em>intelligence</em><br>chaque matin.
            </h1>

            <p class="sd-hero-subtitle">
                SmartDress organise votre garde-robe digitale et vous suggère des tenues
                adaptées à la météo et à vos préférences — pour ne plus jamais perdre de
                temps devant votre armoire.
            </p>

            <div class="flex flex-wrap gap-3 mb-8">
                <a href="{{ route('register') }}" class="sd-btn-primary sd-btn-lg">Essayer gratuitement</a>
                <a href="#how" class="sd-btn-ghost sd-btn-lg">Comment ça marche</a>
            </div>

            <div class="sd-trust-bar" style="margin-bottom:2rem;">
                <span class="sd-trust-item">Gratuit pour commencer</span>
                <span class="sd-trust-item">Sans carte bancaire</span>
                <span class="sd-trust-item">IA incluse</span>
            </div>

            <div class="sd-stats-row">
                <div class="sd-stat">
                    <span class="sd-stat-num">2 min</span>
                    <span class="sd-stat-label">Gagnées / matin</span>
                </div>
                <div class="sd-divider"></div>
                <div class="sd-stat">
                    <span class="sd-stat-num">100%</span>
                    <span class="sd-stat-label">Adapté météo</span>
                </div>
                <div class="sd-divider"></div>
                <div class="sd-stat">
                    <span class="sd-stat-num">∞</span>
                    <span class="sd-stat-label">Combinaisons</span>
                </div>
            </div>
        </div>

        <div class="sd-hero-right">
            <div class="sd-wardrobe sd-illustration-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 520 620" class="sd-hero-svg" aria-label="SmartDress App illustration">
                    <defs>
                        <linearGradient id="bgGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#F5EEE4;stop-opacity:0" />
                            <stop offset="100%" style="stop-color:#E5D7C4;stop-opacity:0" />
                        </linearGradient>
                        <linearGradient id="screenGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#FDFAF6;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#F0E8DB;stop-opacity:1" />
                        </linearGradient>
                        <linearGradient id="phoneGrad" x1="0%" y1="0%" x2="10%" y2="100%">
                            <stop offset="0%" style="stop-color:#3a3028;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#1e1a15;stop-opacity:1" />
                        </linearGradient>
                        <filter id="shadow" x="-20%" y="-20%" width="140%" height="140%">
                            <feDropShadow dx="0" dy="16" stdDeviation="22" flood-color="#5C4A35" flood-opacity="0.22" />
                        </filter>
                        <filter id="softShadow" x="-30%" y="-30%" width="160%" height="160%">
                            <feDropShadow dx="0" dy="4" stdDeviation="8" flood-color="#5C4A35" flood-opacity="0.12" />
                        </filter>
                        <filter id="cardShadow">
                            <feDropShadow dx="0" dy="3" stdDeviation="6" flood-color="#5C4A35" flood-opacity="0.10" />
                        </filter>
                    </defs>

                    <!-- Background circles -->
                    <circle cx="260" cy="310" r="230" fill="#E5D7C4" opacity="0.3" />
                    <circle cx="260" cy="310" r="175" fill="#CFBB99" opacity="0.12" />

                    <!-- SHIRT -->
                    <g filter="url(#softShadow)" class="svg-float-a">
                        <rect x="30" y="96" width="68" height="70" rx="5" fill="#B8A07E" opacity="0.92" />
                        <rect x="26" y="174" width="76" height="20" rx="10" fill="#5C4A35" opacity="0.82" />
                        <text x="64" y="188" text-anchor="middle" font-family="'DM Sans',sans-serif" font-size="8.5" fill="#F5EEE4" letter-spacing="0.5">Chemise</text>
                    </g>
                    <!-- PANTS -->
                    <g filter="url(#softShadow)" class="svg-float-b">
                        <rect x="20" y="372" width="82" height="14" rx="6" fill="#889063" opacity="0.92" />
                        <rect x="20" y="384" width="35" height="86" rx="5" fill="#889063" opacity="0.87" />
                        <rect x="67" y="384" width="35" height="86" rx="5" fill="#7a8058" opacity="0.87" />
                        <rect x="16" y="478" width="90" height="20" rx="10" fill="#5C4A35" opacity="0.82" />
                        <text x="61" y="492" text-anchor="middle" font-family="'DM Sans',sans-serif" font-size="8.5" fill="#F5EEE4" letter-spacing="0.5">Pantalon</text>
                    </g>

                    <!-- PHONE BODY -->
                    <rect x="150" y="52" width="220" height="496" rx="36" fill="url(#phoneGrad)" filter="url(#shadow)" />
                    <rect x="160" y="80" width="200" height="420" rx="16" fill="url(#screenGrad)" />
                    
                    <!-- App Content inside plane -->
                    <text x="260" y="124" text-anchor="middle" font-family="'Cormorant Garamond',Georgia,serif" font-size="17" fill="#5C4A35" letter-spacing="0.5">Smart</text>
                    <text x="300" y="124" font-family="'Cormorant Garamond',Georgia,serif" font-size="17" font-weight="600" font-style="italic" fill="#889063" letter-spacing="0.5">Dress</text>
                    
                    <rect x="170" y="134" width="180" height="50" rx="12" fill="#CFBB99" opacity="0.42" />
                    <text x="260" y="164" text-anchor="middle" font-family="'DM Sans',sans-serif" font-size="8" fill="#5C4A35">Ensoleillé · 22°C · Casablanca</text>

                    <!-- Suggestion card -->
                    <rect x="170" y="230" width="82" height="80" rx="10" fill="#FDFAF6" filter="url(#cardShadow)" />
                    <rect x="260" y="230" width="82" height="80" rx="10" fill="#FDFAF6" filter="url(#cardShadow)" />
                </svg>
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section id="features" class="sd-section">
        <div class="max-w-screen-xl mx-auto px-6 lg:px-12">
            <div class="sd-section-head">
                <div>
                    <span class="sd-tag">Fonctionnalités</span>
                    <h2 class="sd-section-title mt-3">Tout ce dont vous avez <em>besoin</em></h2>
                </div>
                <p class="sd-section-desc">Une application pensée pour simplifier votre quotidien vestimentaire.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-px" style="background:rgba(207,187,153,.2)">
                <div class="sd-feat-card observe-me">
                    <span class="sd-feat-num">01</span>
                    <div class="sd-feat-icon">👗</div>
                    <h3 class="sd-feat-title">Garde-robe digitale</h3>
                    <p class="sd-feat-desc">Numérisez et organisez tous vos vêtements par catégorie.</p>
                </div>
                <div class="sd-feat-card sd-feat-card--alt observe-me">
                    <span class="sd-feat-num">02</span>
                    <div class="sd-feat-icon">🌤️</div>
                    <h3 class="sd-feat-title">Suggestions météo</h3>
                    <p class="sd-feat-desc">Analyse la météo pour suggérer la tenue idéale.</p>
                </div>
                <div class="sd-feat-card observe-me">
                    <span class="sd-feat-num">03</span>
                    <div class="sd-feat-icon">✨</div>
                    <h3 class="sd-feat-title">IA de style</h3>
                    <p class="sd-feat-desc">Notre algorithme apprend vos préférences.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section id="how" class="sd-section" style="background:#5C4A35;color:#F5EEE4">
        <div class="max-w-screen-xl mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <span class="sd-tag sd-tag--light">Comment ça marche</span>
                    <h2 class="sd-section-title mt-3" style="color:#F5EEE4">Simple, <em>rapide</em> et intelligent.</h2>
                    
                    <div class="space-y-4" x-data="{ activeStep: 1 }">
                        <div class="sd-step">
                            <button class="sd-step-btn" @click="activeStep = 1">
                                <span class="sd-step-num">1</span>
                                <span class="sd-step-title">Créez votre compte</span>
                            </button>
                            <div x-show="activeStep === 1" x-collapse>
                                <p class="sd-step-desc">Inscription rapide et sécurisée.</p>
                            </div>
                        </div>
                        <div class="sd-step">
                            <button class="sd-step-btn" @click="activeStep = 2">
                                <span class="sd-step-num">2</span>
                                <span class="sd-step-title">Ajoutez vos vêtements</span>
                            </button>
                            <div x-show="activeStep === 2" x-collapse style="display: none;">
                                <p class="sd-step-desc">Photographiez chaque pièce facilement.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section id="contact" class="sd-cta">
        <div class="max-w-screen-md mx-auto px-6 text-center relative z-10">
            <h2 class="sd-cta-title">Fini le stress du matin.</h2>
            <div class="flex flex-wrap justify-center gap-4 mt-8">
                <a href="{{ route('register') }}" class="sd-btn-primary sd-btn-lg">Créer un compte gratuit</a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="sd-footer">
        <div class="sd-footer-bottom">
            <span>© {{ date('Y') }} SmartDress · Yasmine Haddad</span>
        </div>
    </footer>

    <!-- Initialization Scripts -->
    <script>
        document.addEventListener('alpine:init', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) entry.target.classList.add('visible');
                });
            }, { threshold: 0.15 });

            document.querySelectorAll('.observe-me').forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>
