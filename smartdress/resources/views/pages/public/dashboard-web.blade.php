<!DOCTYPE html>
<html lang="fr text-slate-900">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDress - Tableau de Bord (Web)</title>
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
    <!-- Preline UI -->
    <script src="https://cdn.jsdelivr.net/npm/preline/dist/preline.js"></script>
    <style>
        .clothing-card:hover .zoom-effect { transform: scale(1.1); }
    </style>
</head>

<body class="bg-offwhite font-body text-bark min-h-screen flex flex-col">

    <!-- Header (Style Home) -->
    <header id="navbar" class="sd-navbar scrolled !fixed !bg-white/90">
        <div class="max-w-screen-xl mx-auto px-6 lg:px-12 flex items-center h-full gap-12">
            <a href="../../index.html" class="sd-logo">Smart<span>Dress</span></a>
            
            <nav class="hidden lg:flex items-center gap-8">
                <a href="#" class="sd-navlink !opacity-100 !text-moss font-bold border-b-2 border-moss pb-1">Dashboard</a>
                <a href="garde-robe-web.html" class="sd-navlink">Garde-Robe</a>
                <a href="favoris-web.html" class="sd-navlink">Favoris</a>
                <a href="profile-web.html" class="sd-navlink">Profil</a>
                <a href="contact-web.html" class="sd-navlink">Contact</a>
            </nav>

            <div class="ml-auto hidden lg:flex items-center gap-3">
                <a href="../../index.html" class="sd-btn-ghost !py-2 !px-4 !text-[10px]">Déconnexion</a>
            </div>
        </div>
    </header>

    <div class="h-20"></div> <!-- Spacer for fixed navbar -->

    <main class="flex-1 max-w-7xl w-full mx-auto p-8 grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left Column: Metrics & Quick Actions (Col-4) -->
        <aside class="lg:col-span-4 space-y-8">
            <!-- Weather Widget -->
            <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-bark/5 border border-tan/10 space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-tan uppercase tracking-[0.2em]">Météo locale</p>
                        <p class="text-sm font-medium text-bark">Casablanca, MA</p>
                    </div>
                    <div class="w-16 h-16 bg-cream flex items-center justify-center rounded-2xl shadow-inner border border-tan/10 text-4xl">
                        ⛅
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-5xl font-display font-semibold text-bark">24°</span>
                    <span class="text-xl text-moss italic font-medium">Ensoleillé</span>
                </div>
                <p class="text-xs text-bark/60 leading-relaxed font-light">
                    Conditions idéales pour une tenue légère et respirante aujourd'hui.
                </p>
            </div>

            <!-- Stats / Info -->
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-bark p-6 rounded-[2rem] text-white space-y-2">
                    <p class="text-[9px] font-bold opacity-60 uppercase tracking-widest">Articles</p>
                    <p class="text-3xl font-display italic">42</p>
                </div>
                <div class="bg-moss p-6 rounded-[2rem] text-white space-y-2">
                    <p class="text-[9px] font-bold opacity-60 uppercase tracking-widest">Favoris</p>
                    <p class="text-3xl font-display italic">12</p>
                </div>
            </div>

            <!-- Quick Access -->
            <div class="space-y-4">
                <h3 class="px-4 text-[10px] font-bold text-tan uppercase tracking-widest">Navigation Rapide</h3>
                <div class="grid grid-cols-1 gap-2">
                    <a href="garde-robe-web.html" class="flex items-center justify-between p-4 bg-white rounded-2xl border border-tan/10 hover:border-moss transition-all group">
                        <div class="flex items-center gap-4">
                            <span class="text-xl">🧥</span>
                            <span class="text-sm font-medium text-bark">Gérer mon dressing</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-tan group-hover:text-moss" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="#" class="flex items-center justify-between p-4 bg-white rounded-2xl border border-tan/10 hover:border-moss transition-all group">
                        <div class="flex items-center gap-4">
                            <span class="text-xl">📅</span>
                            <span class="text-sm font-medium text-bark">Planning de la semaine</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-tan group-hover:text-moss" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="favoris-web.html" class="flex items-center justify-between p-4 bg-white rounded-2xl border border-tan/10 hover:border-moss transition-all group">
                        <div class="flex items-center gap-4">
                            <span class="text-xl">⭐</span>
                            <span class="text-sm font-medium text-bark">Mes Favoris</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-tan group-hover:text-moss" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Right Column: Suggestion (Col-8) -->
        <section class="lg:col-span-8">
            <div class="bg-white rounded-[3rem] shadow-2xl shadow-bark/5 overflow-hidden border border-tan/10 flex flex-col md:flex-row h-full">
                <!-- Visual Part -->
                <div class="md:w-1/2 bg-cream/30 relative flex items-center justify-center p-12 min-h-[400px]">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(207,187,153,0.15)_0%,transparent_70%)]"></div>
                    
                    <div class="relative flex flex-col items-center gap-8 scale-110">
                        <div class="w-48 h-48 bg-white rounded-[2.5rem] border-4 border-white shadow-xl flex items-center justify-center flex-col transform -rotate-3 transition-all hover:rotate-0 hover:scale-105" id="top-box">
                            <span class="text-6xl mb-3" id="top-icon">👕</span>
                            <span class="text-[11px] font-bold text-tan uppercase tracking-widest" id="top-name">T-Shirt Blanc</span>
                        </div>
                        <div class="w-52 h-60 bg-bone/20 rounded-[2.5rem] border-4 border-white shadow-xl flex items-center justify-center flex-col transform rotate-2 transition-all hover:rotate-0 hover:scale-105" id="bottom-box">
                            <span class="text-6xl mb-3" id="bottom-icon">👖</span>
                            <span class="text-[11px] font-bold text-deeptan uppercase tracking-widest" id="bottom-name">Jean Slim Bleu</span>
                        </div>
                    </div>

                    <div class="absolute top-8 left-8">
                        <span class="px-6 py-2 bg-moss text-white text-[11px] font-bold rounded-full shadow-lg shadow-moss/20 tracking-[0.2em] uppercase">Suggestion IA</span>
                    </div>
                </div>

                <!-- Info Part -->
                <div class="md:w-1/2 p-12 flex flex-col justify-center space-y-10">
                    <div class="space-y-4">
                        <h2 class="text-5xl font-display font-medium text-bark leading-tight italic" id="outfit-title">Casual Moderne</h2>
                        <p class="text-bark/60 text-lg leading-relaxed font-light">
                            Un look épuré et intemporel. Le blanc apporte du frais tandis que le denim assure le confort. Parfait pour une journée de travail créative ou une sortie en ville.
                        </p>
                    </div>

                    <div class="space-y-4 pt-4">
                        <button class="w-full py-6 bg-moss text-white font-body font-bold text-xs tracking-[0.25em] uppercase rounded-full shadow-2xl shadow-moss/30 hover:bg-bark hover:translate-y-[-4px] transition-all transform duration-300">
                            Porter cet ensemble
                        </button>
                        <button id="refresh-outfit" class="w-full py-5 text-tan hover:text-bark font-body font-bold uppercase tracking-[0.2em] rounded-2xl hover:bg-cream/50 transition-all flex items-center justify-center gap-3 group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:rotate-180 transition-transform duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Générer un autre look
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    
    <!-- Floating Action Button (+) -->
    <button id="add-item-btn" class="fixed bottom-8 right-8 w-16 h-16 bg-moss text-white rounded-full shadow-2xl flex items-center justify-center hover:bg-bark hover:scale-110 active:scale-95 transition-all z-40 group">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 transition-transform group-hover:rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
        </svg>
    </button>

    <!-- Overlay / Backdrop -->
    <div id="modal-overlay" class="fixed inset-0 bg-bark/60 backdrop-blur-sm z-50 hidden opacity-0 transition-opacity duration-300"></div>

    <!-- Modal : Ajouter un vêtement -->
    <div id="modal-add" class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white rounded-[3rem] shadow-2xl z-[60] hidden opacity-0 scale-95 transition-all duration-300 w-full max-w-xl p-12">
        <div class="flex items-center justify-between mb-10">
            <div class="space-y-1">
                <h2 class="text-3xl font-display font-medium text-bark italic">Ajouter au <span class="text-moss">Dressing</span></h2>
                <p class="text-tan text-xs font-medium uppercase tracking-widest">Nouvel article</p>
            </div>
            <button onclick="closeModal('modal-add')" class="w-12 h-12 flex items-center justify-center bg-cream/50 rounded-2xl text-tan hover:text-bark hover:bg-cream transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form class="grid grid-cols-1 md:grid-cols-2 gap-10" onsubmit="return false;">
            <!-- Upload Zone -->
            <div class="space-y-4">
                <input type="file" id="item-photo-input" class="hidden" accept="image/*">
                <div id="upload-zone" onclick="document.getElementById('item-photo-input').click()" 
                    class="aspect-square bg-cream/20 border-2 border-dashed border-tan/20 rounded-[2.5rem] flex flex-col items-center justify-center text-tan hover:bg-cream/40 transition-all cursor-pointer group overflow-hidden relative">
                    <div id="upload-placeholder" class="flex flex-col items-center justify-center">
                        <div class="w-20 h-20 bg-white rounded-3xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-moss" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-widest">Prendre une photo</span>
                        <p class="text-[9px] text-tan/60 mt-2 px-6 text-center">Glissez une image ou cliquez pour parcourir</p>
                    </div>
                    <img id="item-photo-preview" class="absolute inset-0 w-full h-full object-cover hidden" alt="Preview">
                </div>
            </div>

            <!-- Fields Zone -->
            <div class="flex flex-col justify-between py-2">
                <div class="space-y-6">
                    <div class="space-y-1.5">
                        <label class="px-2 text-[10px] font-bold text-tan uppercase tracking-widest">Nom de l'article</label>
                        <input type="text" placeholder="Ex: Veste en cuir vintage" class="w-full px-5 py-4 bg-white border border-tan/10 rounded-2xl focus:border-moss outline-none transition-all font-medium placeholder:text-tan/30 text-sm">
                    </div>

                    <div class="space-y-1.5 relative">
                        <label class="px-2 text-[10px] font-bold text-tan uppercase tracking-widest">Catégorie</label>
                        <select data-hs-select='{
                            "placeholder": "Choisir...",
                            "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                            "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-4 ps-5 pe-12 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-tan/10 rounded-2xl text-start text-sm font-medium focus:ring-1 focus:ring-moss appearance-none",
                            "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-tan/10 rounded-2xl overflow-hidden overflow-y-auto shadow-2xl",
                            "optionClasses": "py-3 px-5 w-full text-sm text-bark cursor-pointer hover:bg-cream/50 rounded-xl focus:outline-none focus:bg-cream/50 transition-colors",
                            "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-moss\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"3\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>"
                          }'>
                            <option value="">Choisir...</option>
                            <option value="hauts">Hauts</option>
                            <option value="bas">Bas</option>
                            <option value="chaussures">Chaussures</option>
                            <option value="accessoires">Accessoires</option>
                        </select>
                        <div class="absolute top-[2.4rem] end-4 pointer-events-none">
                            <svg class="shrink-0 size-4 text-tan/60" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"></path><path d="m7 9 5-5 5 5"></path></svg>
                        </div>
                    </div>
                </div>

                <button id="save-item-btn" type="button" onclick="addItemToGrid()" class="w-full py-5 bg-moss text-white rounded-full text-[10px] font-bold uppercase tracking-[0.2em] shadow-xl shadow-moss/20 hover:bg-bark transition-all mt-8">
                    Ajouter au dressing
                </button>
            </div>
        </form>
    </div>

    <script>
        const outfits = [
            { title: "Casual Moderne", top: "👕", topName: "T-Shirt Blanc", topBg: "bg-white", bottom: "👖", bottomName: "Jean Slim Bleu", bottomBg: "bg-bone/20" },
            { title: "Élégance Soirée", top: "👔", topName: "Chemise Noire", topBg: "bg-slate-800 text-white", bottom: "👖", bottomName: "Pantalon Costume", bottomBg: "bg-slate-300" },
            { title: "Weekend Chill", top: "🧥", topName: "Hoodie Moss", topBg: "bg-moss text-white", bottom: "🩳", bottomName: "Short Cargo", bottomBg: "bg-tan/20" }
        ];

        let currentIndex = 0;
        const refreshBtn = document.getElementById('refresh-outfit');
        const titleEl = document.getElementById('outfit-title');
        const topIcon = document.getElementById('top-icon');
        const topName = document.getElementById('top-name');
        const topBox = document.getElementById('top-box');
        const bottomIcon = document.getElementById('bottom-icon');
        const bottomName = document.getElementById('bottom-name');
        const bottomBox = document.getElementById('bottom-box');

        refreshBtn.addEventListener('click', () => {
            refreshBtn.classList.add('opacity-50', 'pointer-events-none');
            
            setTimeout(() => {
                currentIndex = (currentIndex + 1) % outfits.length;
                const o = outfits[currentIndex];
                
                titleEl.textContent = o.title;
                topIcon.textContent = o.top;
                topName.textContent = o.topName;
                topBox.className = `w-48 h-48 ${o.topBg.split(' ')[0]} rounded-[2.5rem] border-4 border-white shadow-xl flex items-center justify-center flex-col transform -rotate-3 transition-all hover:rotate-0 hover:scale-105`;
                
                bottomIcon.textContent = o.bottom;
                bottomName.textContent = o.bottomName;
                bottomBox.className = `w-52 h-60 ${o.bottomBg} rounded-[2.5rem] border-4 border-white shadow-xl flex items-center justify-center flex-col transform rotate-2 transition-all hover:rotate-0 hover:scale-105`;

                refreshBtn.classList.remove('opacity-50', 'pointer-events-none');
            }, 600);
        });

        // ── Modal logic Web ──
        const modalOverlay = document.getElementById('modal-overlay');
        const addItemBtn = document.getElementById('add-item-btn');

        function openModal(id) {
            const modal = document.getElementById(id);
            modalOverlay.classList.remove('hidden');
            setTimeout(() => modalOverlay.classList.add('opacity-100'), 10);
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('opacity-100', 'scale-100');
                modal.classList.remove('scale-95');
            }, 50);
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('opacity-100', 'scale-100');
            modal.classList.add('scale-95');
            modalOverlay.classList.remove('opacity-100');
            setTimeout(() => {
                modal.classList.add('hidden');
                modalOverlay.classList.add('hidden');
            }, 300);
        }

        if (addItemBtn) {
            addItemBtn.addEventListener('click', () => openModal('modal-add'));
        }
        if (modalOverlay) {
            modalOverlay.addEventListener('click', () => closeModal('modal-add'));
        }

        // ── Photo Upload Preview Logic ──
        const photoInput = document.getElementById('item-photo-input');
        const photoPreview = document.getElementById('item-photo-preview');
        const uploadPlaceholder = document.getElementById('upload-placeholder');

        if (photoInput) {
            photoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        photoPreview.src = e.target.result;
                        photoPreview.classList.remove('hidden');
                        uploadPlaceholder.classList.add('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        // ── Dynamic Add Item Logic ──
        function addItemToGrid() {
            const nameInput = document.querySelector('#modal-add input[type="text"]');
            const categorySelect = document.querySelector('#modal-add select');
            const photoPreview = document.getElementById('item-photo-preview');

            if (!nameInput.value || !categorySelect.value) {
                alert("Veuillez remplir le nom et la catégorie.");
                return;
            }

            // Since dashboard-web doesn't have a grid of items (it has outfits),
            // we will simulate the "success" and maybe show a toast or a visual hint.
            // For now, let's just show an alert and follow the same reset logic for consistency.
            
            alert(`Article "${nameInput.value}" ajouté avec succès à la catégorie ${categorySelect.value} !`);

            // Reset and close
            nameInput.value = '';
            HSSelect.getInstance('#modal-add select', true).element.setValue('');
            photoPreview.src = '';
            photoPreview.classList.add('hidden');
            document.getElementById('upload-placeholder').classList.remove('hidden');
            closeModal('modal-add');
        }
    </script>
</body>

</html>

