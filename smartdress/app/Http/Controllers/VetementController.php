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
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vetements = $this->vetementService->getForUser(Auth::user());

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
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'categorie' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'couleur' => 'nullable|string',
            'saison' => 'nullable|string',
            'style' => 'nullable|string',
        ]);

        $this->vetementService->createForUser(Auth::user(), $validated, $request->file('photo'));

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
