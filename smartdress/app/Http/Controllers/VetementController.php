<?php

namespace App\Http\Controllers;

use App\Models\Vetement;
use App\Services\VetementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VetementController extends Controller
{
    public function __construct(
        private readonly VetementService $vetementService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vetements = $this->vetementService->getForUser(Auth::user(), true);
        return view('vetements.index', compact('vetements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vetements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \Log::info('=== STORE VETEMENT START ===');
        \Log::info('Auth user: ' . (Auth::check() ? Auth::id() : 'NOT LOGGED IN'));
        \Log::info('Has photo file: ' . ($request->hasFile('photo') ? 'YES' : 'NO'));
        \Log::info('Request data: ', $request->except('photo'));

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'categorie' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Validation pour la photo
            'couleur' => 'nullable|string',
            'saison' => 'nullable|string',
            'style' => 'nullable|string',
        ]);

        $vetement = $this->vetementService->createForUser(
            Auth::user(),
            $validated,
            $request->file('photo')
        );

        \Log::info('Vetement created: id=' . $vetement->id . ' user_id=' . $vetement->user_id);
        \Log::info('=== STORE VETEMENT END ===');
        return redirect()->route('garde-robe')->with('success', 'Vêtement ajouté avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vetement $vetement)
    {
        return view('vetements.show', compact('vetement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vetement $vetement)
    {
        return view('vetements.edit', compact('vetement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vetement $vetement)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'categorie' => 'required|string',
            'couleur' => 'nullable|string',
            'saison' => 'nullable|string',
            'style' => 'nullable|string',
        ]);

        $this->vetementService->update($vetement, $validated);

        return redirect()->route('vetements.index')->with('success', 'Vêtement mis à jour !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vetement $vetement)
    {
        $this->vetementService->deleteWithPhotos($vetement);

        return redirect()->route('garde-robe')->with('success', 'Vêtement supprimé !');
    }
}
