<!DOCTYPE html>
<html lang="fr text-slate-900">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDress - Authentification</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/preline/dist/preline.js"></script>
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

<body class="bg-bark font-body text-bark min-h-screen flex items-center justify-center p-6 relative overflow-x-hidden">

    <!-- Background Flow Effect -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&q=80')] bg-cover bg-center blur-md scale-110 opacity-60"></div>
        <div class="absolute inset-0 bg-bark/20 mix-blend-multiply"></div>
    </div>

    <div class="w-full max-w-[450px] my-8 relative z-10">
        <!-- Form Container -->
        <div class="bg-white p-10 rounded-[3rem] shadow-2xl shadow-bark/40 space-y-6 relative overflow-hidden">
            
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <a href="{{ url("/") }}" class="p-1 hover:bg-cream/50 rounded-full transition-colors text-tan flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <a href="{{ url("/") }}" class="sd-logo">Smart<span>Dress</span></a>
                </div>
                
                <div class="space-y-1">
                    <h2 class="text-3xl font-display font-medium text-bark italic leading-tight">Bienvenue</h2>
                    <p class="text-tan text-[10px] font-light">Connectez-vous pour votre garde-robe.</p>
                </div>
            </div>

            <div class="flex p-1 bg-[#FAF9F6] rounded-xl" id="auth-tabs">
                <button data-target="login"
                    class="tab-btn flex-1 py-2.5 text-[9px] font-bold uppercase tracking-widest bg-white text-bark rounded-lg shadow-sm transition-all">Connexion</button>
                <button data-target="register"
                    class="tab-btn flex-1 py-2.5 text-[9px] font-bold uppercase tracking-widest text-tan hover:text-bark transition-all">Inscription</button>
            </div>

            <!-- Login Form -->
            <form id="login-form" action="{{ route('login.post') }}" method="POST" class="auth-form space-y-5">
                @csrf
                <div class="space-y-1.5">
                    <label class="text-[9px] font-bold text-tan uppercase tracking-[0.2em] ml-1">Email</label>
                    <input type="email" name="email" placeholder="nom@exemple.com" required
                        class="w-full px-5 py-3.5 bg-white border border-tan/10 rounded-xl focus:border-bark outline-none transition-all placeholder:text-tan/50 text-bark text-xs">
                </div>
                <div class="space-y-1.5">
                    <div class="flex justify-between items-center ml-1">
                        <label class="text-[9px] font-bold text-tan uppercase tracking-[0.2em]">Mot de passe</label>
                        <a href="#" class="text-[9px] font-bold text-bark hover:text-moss uppercase tracking-widest transition-colors">Oublié ?</a>
                    </div>
                    <input type="password" name="password" placeholder="••••••••" required
                        class="w-full px-5 py-3.5 bg-white border border-tan/10 rounded-xl focus:border-bark outline-none transition-all placeholder:text-tan/50 text-bark text-xs">
                </div>

                <button type="submit"
                    class="w-full py-4 bg-bark text-white font-body font-bold text-[10px] tracking-[0.2em] uppercase rounded-full shadow-lg shadow-bark/30 hover:bg-[#4A3B2A] transform hover:scale-[1.02] transition-all mt-2">
                    Se connecter
                </button>
            </form>

            <!-- Register Form -->
            <form id="register-form" class="auth-form space-y-5 hidden">
                <div class="space-y-1.5">
                    <label class="text-[9px] font-bold text-tan uppercase tracking-[0.2em] ml-1">Nom complet</label>
                    <input type="text" placeholder="Jean Dupont" required
                        class="w-full px-5 py-3.5 bg-white border border-tan/10 rounded-xl focus:border-bark outline-none transition-all placeholder:text-tan/50 text-bark text-xs">
                </div>
                <div class="space-y-1.5">
                    <label class="text-[9px] font-bold text-tan uppercase tracking-[0.2em] ml-1">Email</label>
                    <input type="email" placeholder="nom@exemple.com" required
                        class="w-full px-5 py-3.5 bg-white border border-tan/10 rounded-xl focus:border-bark outline-none transition-all placeholder:text-tan/50 text-bark text-xs">
                </div>
                <div class="space-y-1.5">
                    <label class="text-[9px] font-bold text-tan uppercase tracking-[0.2em] ml-1">Mot de passe</label>
                    <input type="password" placeholder="••••••••" required
                        class="w-full px-5 py-3.5 bg-white border border-tan/10 rounded-xl focus:border-bark outline-none transition-all placeholder:text-tan/50 text-bark text-xs">
                </div>

                <button type="submit"
                    class="w-full py-4 bg-bark text-white font-body font-bold text-[10px] tracking-[0.2em] uppercase rounded-full shadow-lg shadow-bark/30 hover:bg-[#4A3B2A] transform hover:scale-[1.02] transition-all mt-2">
                    Créer mon compte
                </button>
            </form>

            <div class="relative py-1">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-tan/10"></div>
                </div>
                <div class="relative flex justify-center text-[9px] font-bold uppercase tracking-[0.2em]">
                    <span class="bg-white px-3 text-tan/60">Ou continuer avec</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <button
                    class="flex items-center justify-center gap-2.5 py-3.5 bg-white border border-tan/20 rounded-xl hover:bg-cream/20 hover:border-tan/40 transition-all group">
                    <!-- Google SVG Logo -->
                    <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    <span class="text-[9px] font-bold text-tan uppercase tracking-widest group-hover:text-bark transition-colors">Google</span>
                </button>
                <button
                    class="flex items-center justify-center gap-2.5 py-3.5 bg-white border border-tan/20 rounded-xl hover:bg-cream/20 hover:border-tan/40 transition-all group">
                    <!-- Apple SVG Logo -->
                    <svg class="w-4 h-4 flex-shrink-0 text-bark" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                        <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
                    </svg>
                    <span class="text-[9px] font-bold text-tan uppercase tracking-widest group-hover:text-bark transition-colors">Apple</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        const tabs = document.querySelectorAll('.tab-btn');
        const forms = document.querySelectorAll('.auth-form');

        function switchTab(target) {
            tabs.forEach(t => {
                t.classList.remove('bg-white', 'text-bark', 'shadow-sm');
                t.classList.add('text-tan');
                if (t.dataset.target === target) {
                    t.classList.add('bg-white', 'text-bark', 'shadow-sm');
                    t.classList.remove('text-tan');
                }
            });
            forms.forEach(f => {
                f.classList.add('hidden');
                if (f.id === `${target}-form`) {
                    f.classList.remove('hidden');
                }
            });
        }

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                switchTab(tab.dataset.target);
            });
        });

        // Handle URL parameters for Login vs Register
        window.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const mode = urlParams.get('mode');
            if (mode === 'register') {
                switchTab('register');
            } else if (mode === 'login') {
                switchTab('login');
            }
        });

        document.getElementById('login-form').addEventListener('submit', (e) => {
            // Ne pas appeler e.preventDefault() pour laisser Laravel gérer la redirection
            const btn = e.target.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.innerHTML = '<span class="flex items-center justify-center gap-2">Connexion...</span>';
        });

        document.getElementById('register-form').addEventListener('submit', (e) => {
            e.preventDefault();
            const btn = e.target.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.innerHTML = '<span class="flex items-center justify-center gap-2">Création en cours...</span>';
            setTimeout(() => {
                window.location.href = '{{ route("dashboard") }}';
            }, 800);
        });
    </script>
</body>

</html>
