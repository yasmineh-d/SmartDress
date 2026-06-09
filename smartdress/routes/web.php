<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http; // Importation essentielle pour l'API
use App\Http\Controllers\VetementController;
use App\Http\Controllers\TenueController;
use App\Http\Controllers\FavorisController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Models\Vetement;
use App\Http\Controllers\PlanningController;

// --- Pages Publiques ---
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return view('pages.public.about-web');
})->name('about');

Route::get('/contact', function () {
    return view('pages.public.contact-web');
})->name('contact');

Route::get('/login', function () {
    return view('pages.public.auth');
})->name('login');


// --- Pages Utilisateur (Web) ---
Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $hauts = $user->vetements()->where('categorie', 'hauts')->with('photos')->get();
        $bas = $user->vetements()->where('categorie', 'bas')->with('photos')->get();
        
        $totalArticles = $user->vetements()->count();
        $totalFavoris = $user->favoris()->count();

        // --- Logique de l'API Météo (Exemple OpenWeather) ---
        // Remplace 'VOTRE_CLE_API' par ta vraie clé OpenWeatherMap
        $apiKey = config('services.openweather.key', 'VOTRE_CLE_API'); 
        $ville = 'Tangier'; 

        try {
            // Appel de l'API météo
            $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
                'q' => $ville,
                'appid' => $apiKey,
                'units' => 'metric',
                'lang' => 'fr'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $meteo = [
                    'ville' => $data['name'] ?? 'Tanger',
                    'temperature' => round($data['main']['temp'] ?? 22),
                    'icone' => ucfirst($data['weather'][0]['description'] ?? 'Ensoleillé')
                ];
            } else {
                throw new \Exception("Échec de l'API");
            }
        } catch (\Exception $e) {
            // Valeurs de secours (Fallback) si l'API échoue ou s'il n'y a pas internet
            $meteo = [
                'ville' => 'Tanger',
                'temperature' => 24,
                'icone' => 'Partiellement nuageux'
            ];
        }

        return view('pages.public.dashboard-web', compact('hauts', 'bas', 'totalArticles', 'totalFavoris', 'meteo'));
    })->name('dashboard');

    Route::get('/garde-robe', function () {
        $user = auth()->user();
        $vetements = $user->vetements()
            ->with('photos')
            ->latest()
            ->get();
        
        $favorisIds = $user->favoris()->pluck('vetement_id')->toArray();

        return view('pages.public.garde-robe-web', compact('vetements', 'favorisIds'));
    })->name('garde-robe');


    Route::get('/favoris', function () {
        $favoris = auth()->user()
            ->favoris()
            ->with(['vetement.photos', 'tenue'])
            ->latest()
            ->get();
        return view('pages.public.favoris-web', compact('favoris'));
    })->name('favoris');

    Route::get('/profil', function () {
        return view('pages.public.profile-web');
    })->name('profile');

    Route::get('/modifier-profil', function () {
        return view('pages.public.edit-profile-web');
    })->name('profile.edit');

    Route::get('/changer-mot-de-passe', function () {
        return view('pages.public.change-password-web');
    })->name('password.change');

    // --- Planning de la semaine ---
    Route::get('/planning', [PlanningController::class, 'index'])->name('planning.index');
    Route::post('/planning', [PlanningController::class, 'store'])->name('planning.store');
    Route::delete('/planning/{planning}', [PlanningController::class, 'destroy'])->name('planning.destroy');

    // --- Resources (API/CRUD) ---
    Route::resource('vetements', VetementController::class);
    Route::resource('tenues', TenueController::class);
    Route::resource('favoris-api', FavorisController::class);

    // --- Pages Admin ---
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
});


// --- Authentification (Logique) ---
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Compatibilité Mobiles ---
Route::get('/mobile/dashboard', function () { return view('pages.public.dashboard_mobile'); })->name('mobile.dashboard');
Route::get('/mobile/edit-profile', function () { return view('pages.public.edit-profile-mobile'); })->name('mobile.profile.edit');