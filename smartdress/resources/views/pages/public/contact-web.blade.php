<!DOCTYPE html>
<html lang="fr text-slate-900">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDress - Contact</title>
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
</head>

<body class="bg-offwhite font-body text-bark min-h-screen flex flex-col">

    <!-- Header -->
    <header id="navbar" class="sd-navbar scrolled !fixed !bg-white/90">
        <div class="max-w-screen-xl mx-auto px-6 lg:px-12 flex items-center justify-between h-full">
            <a href="/" class="sd-logo">Smart<span>Dress</span></a>
            
            <nav class="hidden lg:flex items-center gap-8">
                <a href="/#features" class="sd-navlink">Fonctionnalités</a>
                <a href="/#how" class="sd-navlink">Comment ça marche</a>
                <a href="/#trust" class="sd-navlink">Témoignages</a>
                <a href="/contact" class="sd-navlink">Contact</a>
            </nav>

            <div class="hidden lg:flex items-center gap-3">
                <a href="/pages/public/{{ route("login", ["mode" => "login"]) }}" class="sd-btn-ghost">Se connecter</a>
                <a href="/pages/public/{{ route("login", ["mode" => "register"]) }}" class="sd-btn-primary">Commencer</a>
            </div>
        </div>
    </header>

    <div class="h-20"></div>

    <main class="flex-1 max-w-6xl w-full mx-auto p-8 lg:p-20">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-start">
            
            <div class="space-y-10">
                <div class="space-y-4">
                    <div class="flex items-center gap-6 mb-2">
                        <a href="/" class="w-12 h-12 flex items-center justify-center bg-white rounded-2xl text-bark hover:bg-moss hover:text-white transition-all shadow-xl shadow-bark/5 border border-tan/10 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <h1 class="text-6xl font-display font-medium text-bark italic leading-tight">Parlons de votre <span class="text-moss">Style</span></h1>
                    </div>
                    <p class="text-lg text-tan font-light leading-relaxed">
                        Une question, une suggestion ou besoin d'assistance ? Notre équipe est là pour vous accompagner dans votre expérience SmartDress.
                    </p>
                </div>

                <div class="space-y-8">
                    <div class="flex items-center gap-6 group">
                        <div class="w-14 h-14 bg-moss/10 rounded-2xl flex items-center justify-center text-moss group-hover:bg-moss group-hover:text-white transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-tan uppercase tracking-widest">Email</p>
                            <p class="text-bark font-medium">contact@smartdress.fr</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-6 group">
                        <div class="w-14 h-14 bg-moss/10 rounded-2xl flex items-center justify-center text-moss group-hover:bg-moss group-hover:text-white transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-tan uppercase tracking-widest">Siège Social</p>
                            <p class="text-bark font-medium">123 Avenue de la Mode, 75001 Paris</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-10 lg:p-14 rounded-[3.5rem] shadow-2xl shadow-bark/5 border border-tan/10 space-y-8 relative">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-moss/5 rounded-full blur-2xl"></div>
                
                <h3 class="text-2xl font-display font-medium text-bark italic">Envoyez-nous un message</h3>
                
                <form class="space-y-6" onsubmit="event.preventDefault(); alert('Message envoyé ! Nous vous répondrons sous 24h.'); this.reset();">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-1.5">
                            <label class="px-2 text-[10px] font-bold text-tan uppercase tracking-widest">Nom</label>
                            <input type="text" required placeholder="Votre nom" class="w-full px-6 py-4 bg-cream/20 border border-tan/10 rounded-2xl focus:border-moss outline-none transition-all placeholder:text-tan/30 text-sm">
                        </div>
                        <div class="space-y-1.5">
                            <label class="px-2 text-[10px] font-bold text-tan uppercase tracking-widest">Email</label>
                            <input type="email" required placeholder="votre@email.com" class="w-full px-6 py-4 bg-cream/20 border border-tan/10 rounded-2xl focus:border-moss outline-none transition-all placeholder:text-tan/30 text-sm">
                        </div>
                    </div>
                    
                    <div class="space-y-1.5">
                        <label class="px-2 text-[10px] font-bold text-tan uppercase tracking-widest">Sujet</label>
                        <input type="text" placeholder="Comment pouvons-nous vous aider ?" class="w-full px-6 py-4 bg-cream/20 border border-tan/10 rounded-2xl focus:border-moss outline-none transition-all placeholder:text-tan/30 text-sm">
                    </div>

                    <div class="space-y-1.5">
                        <label class="px-2 text-[10px] font-bold text-tan uppercase tracking-widest">Message</label>
                        <textarea rows="4" required placeholder="Racontez-nous tout..." class="w-full px-6 py-4 bg-cream/20 border border-tan/10 rounded-2xl focus:border-moss outline-none transition-all placeholder:text-tan/30 text-sm resize-none"></textarea>
                    </div>

                    <button type="submit" class="w-full py-5 bg-moss text-white rounded-full text-[10px] font-bold uppercase tracking-[0.2em] shadow-xl shadow-moss/20 hover:bg-bark transition-all">
                        Envoyer le message
                    </button>
                </form>
            </div>

        </div>

    </main>

    <!-- FOOTER (Style Home) -->
    <footer class="sd-footer !mt-20">
        <div class="max-w-screen-xl mx-auto px-6 lg:px-12 py-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
            <div>
                <a href="/" class="sd-logo sd-logo--light">Smart<span>Dress</span></a>
                <p class="sd-footer-tag">Votre garde-robe digitale intelligente. Suggestions de tenues basées sur la météo et vos préférences.</p>
            </div>
            <div>
                <h4 class="sd-footer-heading">Application</h4>
                <ul class="sd-footer-links">
                    <li><a href="/#features">Fonctionnalités</a></li>
                    <li><a href="#">Garde-robe</a></li>
                    <li><a href="#">Suggestions</a></li>
                    <li><a href="#">Notifications</a></li>
                </ul>
            </div>
            <div>
                <h4 class="sd-footer-heading">Compte</h4>
                <ul class="sd-footer-links">
                    <li><a href="/pages/public/{{ route("login", ["mode" => "register"]) }}">S'inscrire</a></li>
                    <li><a href="/pages/public/{{ route("login", ["mode" => "login"]) }}">Se connecter</a></li>
                </ul>
            </div>
            <div>
                <h4 class="sd-footer-heading">Projet</h4>
                <ul class="sd-footer-links">
                    <li><a href="/pages/public/{{ route("about") }}">À propos</a></li>
                    <li><a href="#">Rapport PFF</a></li>
                    <li><a href="/contact">Contact</a></li>
                    <li><a href="#">Mentions légales</a></li>
                </ul>
            </div>
        </div>
        <div class="sd-footer-bottom">
            <span>© 2025–2026 SmartDress · Yasmine Haddad</span>
            <span>Formation Développement Mobile · Mode Bootcamp</span>
        </div>
    </footer>

</body>
</html>

