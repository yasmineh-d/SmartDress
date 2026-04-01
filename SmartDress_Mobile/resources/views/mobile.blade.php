<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SmartDress Mobile</title>
  <script src="https://cdn.tailwindcss.com"></script>
  @vite(['resources/js/app.js'])
  <style>
    body { font-family: sans-serif; }
    [x-cloak] { display: none !important; }
  </style>
</head>
<body x-data="appData()" x-init="fetchData()" class="bg-gray-100 min-h-screen pb-20">
  <header class="bg-indigo-600 text-white p-4 sticky top-0 z-10">
    <h1 class="text-xl font-bold text-center">SmartDress</h1>
  </header>

  <nav class="flex justify-around bg-white shadow p-2 sticky top-16 z-10">
    <button @click="changePage('vetements')" 
            :class="currentPage === 'vetements' ? 'bg-indigo-600 text-white' : 'bg-gray-200'"
            class="px-4 py-2 rounded-lg text-sm font-medium transition">
      Vêtements
    </button>
    <button @click="changePage('tenues')" 
            :class="currentPage === 'tenues' ? 'bg-indigo-600 text-white' : 'bg-gray-200'"
            class="px-4 py-2 rounded-lg text-sm font-medium transition">
      Tenues
    </button>
    <button @click="changePage('favoris')" 
            :class="currentPage === 'favoris' ? 'bg-indigo-600 text-white' : 'bg-gray-200'"
            class="px-4 py-2 rounded-lg text-sm font-medium transition">
      Favoris
    </button>
  </nav>

  <main class="p-4 max-w-md mx-auto">
    <div x-show="loading" x-cloak class="animate-pulse">
      <div class="bg-white p-4 rounded-lg shadow mb-3">
        <div class="h-4 bg-gray-300 rounded w-3/4 mb-2"></div>
        <div class="h-3 bg-gray-200 rounded w-1/2"></div>
      </div>
    </div>

    <div x-show="error && !loading" x-cloak class="bg-red-100 text-red-700 p-4 rounded-lg">
      <p x-text="error"></p>
      <button @click="fetchData()" class="mt-2 text-sm underline">Réessayer</button>
    </div>

    <!-- Vêtements -->
    <template x-if="currentPage === 'vetements' && !loading">
      <div>
        <p class="text-gray-500 text-sm mb-3" x-text="vetements.length + ' vêtements'"></p>
        <div class="grid gap-3">
          <template x-for="v in vetements" :key="v.id">
            <div class="bg-white p-4 rounded-lg shadow">
              <h3 class="font-semibold" x-text="v.nom"></h3>
              <div class="flex gap-2 mt-2">
                <span class="bg-indigo-100 text-indigo-700 text-xs px-2 py-1 rounded" x-text="v.categorie"></span>
                <span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded" x-text="v.couleur"></span>
              </div>
              <div class="flex gap-2 mt-2">
                <span class="bg-blue-50 text-blue-600 text-xs px-2 py-1 rounded" x-text="v.saison || 'Toutes saisons'"></span>
                <span class="bg-green-50 text-green-600 text-xs px-2 py-1 rounded" x-text="v.style || 'Classic'"></span>
              </div>
            </div>
          </template>
        </div>
        <div x-show="vetements.length === 0" class="text-center text-gray-500 py-8">
          Aucun vêtement trouvé
        </div>
      </div>
    </template>

    <!-- Tenues -->
    <template x-if="currentPage === 'tenues' && !loading">
      <div>
        <p class="text-gray-500 text-sm mb-3" x-text="tenues.length + ' tenues'"></p>
        <div class="grid gap-4">
          <template x-for="t in tenues" :key="t.id">
            <div class="bg-white p-4 rounded-lg shadow">
              <h3 class="font-semibold" x-text="t.nom"></h3>
              <p class="text-sm text-gray-500 mt-1" x-text="'Météo: ' + (t.meteo_adaptee || 'Toutes')"></p>
              <template x-if="t.conseil_ia">
                <p class="text-xs text-indigo-600 mt-1 italic" x-text="t.conseil_ia"></p>
              </template>
              <div class="mt-3">
                <p class="text-xs text-gray-400 mb-2">Vêtements:</p>
                <div class="flex flex-wrap gap-1">
                  <template x-for="v in t.vetements" :key="v.id">
                    <span class="bg-purple-100 text-purple-700 text-xs px-2 py-1 rounded" x-text="v.nom"></span>
                  </template>
                </div>
              </div>
            </div>
          </template>
        </div>
        <div x-show="tenues.length === 0" class="text-center text-gray-500 py-8">
          Aucune tenue trouvée
        </div>
      </div>
    </template>

    <!-- Favoris -->
    <template x-if="currentPage === 'favoris' && !loading">
      <div>
        <p class="text-gray-500 text-sm mb-3" x-text="favoris.length + ' favoris'"></p>
        <div class="grid gap-3">
          <template x-for="f in favoris" :key="f.id">
            <div class="bg-white p-4 rounded-lg shadow flex justify-between items-center">
              <div>
                <template x-if="f.vetement">
                  <div>
                    <p class="font-medium" x-text="f.vetement.nom"></p>
                    <span class="text-xs text-gray-500">Vêtement favori</span>
                  </div>
                </template>
                <template x-if="f.tenue">
                  <div>
                    <p class="font-medium" x-text="f.tenue.nom"></p>
                    <span class="text-xs text-gray-500">Tenue favorite</span>
                  </div>
                </template>
              </div>
              <span class="text-red-500">♥</span>
            </div>
          </template>
        </div>
        <div x-show="favoris.length === 0" class="text-center text-gray-500 py-8">
          Aucun favori
        </div>
      </div>
    </template>
  </main>
</body>
</html>
