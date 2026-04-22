<!DOCTYPE html>
<html lang="fr text-slate-900">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDress - Modifier Profile (Web)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400;1,600&family=DM+Sans:wght@300;400;500;700&display=swap"
        rel="stylesheet">
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

<body class="bg-offwhite font-body text-bark min-h-screen flex flex-col">

    <!-- Header (Style Home) -->
    <header id="navbar" class="sd-navbar scrolled !fixed !bg-white/90">
        <div class="max-w-screen-xl mx-auto px-6 lg:px-12 flex items-center h-full gap-12">
            <a href="{{ url("/") }}" class="sd-logo">Smart<span>Dress</span></a>

            <nav class="hidden lg:flex items-center gap-8">
                <a href="{{ route("dashboard") }}" class="sd-navlink">Dashboard</a>
                <a href="{{ route("garde-robe") }}" class="sd-navlink">Garde-Robe</a>
                <a href="{{ route("favoris") }}" class="sd-navlink">Favoris</a>
                <a href="{{ route("profile") }}" class="sd-navlink">Profil</a>
            </nav>

            <div class="ml-auto hidden lg:flex items-center gap-3">
                <a href="{{ url("/") }}" class="sd-btn-ghost !py-2 !px-4 !text-[10px]">Déconnexion</a>
            </div>
        </div>
    </header>

    <div class="h-20"></div> <!-- Spacer for fixed navbar -->

    <main class="flex-1 max-w-2xl w-full mx-auto p-12">
        <div class="space-y-12">
            <div class="flex items-center gap-4">
                <button onclick="location.href='{{ route("profile") }}'" class="w-10 h-10 flex items-center justify-center bg-white border border-tan/10 rounded-xl hover:bg-cream transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-tan" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <h1 class="text-4xl font-display font-medium text-bark italic">Modifier le <span class="text-moss">Profil</span></h1>
            </div>

            <div class="bg-white p-10 rounded-[3rem] shadow-xl shadow-bark/5 border border-tan/10 space-y-10">
                <div class="flex flex-col items-center gap-6">
                    <div class="relative w-32 h-32">
                        <div class="w-full h-full rounded-[2.5rem] bg-gradient-to-tr from-bark to-tan p-1">
                            <div class="w-full h-full bg-white rounded-[2.2rem] overflow-hidden flex items-center justify-center">
                                <img id="profile-preview" src="https://ui-avatars.com/api/?name=User&background=5C4A35&color=fff&size=256"
                                    alt="Avatar Large" class="w-full h-full object-cover">
                            </div>
                        </div>
                        <label for="avatar-upload" class="absolute bottom-0 right-0 w-10 h-10 bg-moss text-white rounded-full shadow-lg border-4 border-white flex items-center justify-center cursor-pointer hover:scale-110 transition-transform">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </label>
                        <input type="file" id="avatar-upload" class="hidden" accept="image/*">
                    </div>
                </div>

                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="px-2 text-[10px] font-bold text-tan uppercase tracking-widest">Nom complet</label>
                            <input type="text" value="Yasmine Haddad" class="w-full px-6 py-4 bg-offwhite border border-tan/10 rounded-2xl focus:outline-none focus:border-moss focus:ring-4 focus:ring-moss/5 transition-all text-bark font-medium">
                        </div>
                        <div class="space-y-2">
                            <label class="px-2 text-[10px] font-bold text-tan uppercase tracking-widest">Email</label>
                            <input type="email" value="yasmine@example.com" class="w-full px-6 py-4 bg-offwhite border border-tan/10 rounded-2xl focus:outline-none focus:border-moss focus:ring-4 focus:ring-moss/5 transition-all text-bark font-medium">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="px-2 text-[10px] font-bold text-tan uppercase tracking-widest">Bio</label>
                        <textarea class="w-full px-6 py-4 bg-offwhite border border-tan/10 rounded-2xl focus:outline-none focus:border-moss focus:ring-4 focus:ring-moss/5 transition-all text-bark font-medium h-32 resize-none" placeholder="Parlez-nous de votre style..."></textarea>
                    </div>

                    <div class="pt-6 flex flex-col md:flex-row gap-4">
                        <button type="button" onclick="location.href='{{ route("profile") }}'" class="flex-1 py-4 border border-tan/20 text-tan rounded-full text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-cream/30 transition-all">
                            Annuler
                        </button>
                        <button type="submit" class="flex-1 py-4 bg-moss text-white rounded-full text-[10px] font-bold uppercase tracking-[0.2em] shadow-lg shadow-moss/20 hover:bg-bark transition-all">
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="sd-footer !mt-20">
        <div class="sd-footer-bottom">
            <span>© 2025–2026 SmartDress · Yasmine Haddad</span>
            <span>Formation Développement Mobile · Mode Bootcamp</span>
        </div>
    </footer>

</body>

</html>

