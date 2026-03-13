<?php

namespace App\Http\Controllers;

use App\Models\Vetement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VetementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vetements = Auth::user()->vetements ?? Vetement::where('user_id', Auth::id())->get();
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
            'couleur' => 'nullable|string',
            'saison' => 'nullable|string',
            'style' => 'nullable|string',
        ]);

        $vetement = Auth::user()->vetements()->create($validated);

        return redirect()->route('vetements.index')->with('success', 'Vêtement ajouté avec succès !');
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

        $vetement->update($validated);

        return redirect()->route('vetements.index')->with('success', 'Vêtement mis à jour !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vetement $vetement)
    {
        $vetement->delete();

        return redirect()->route('vetements.index')->with('success', 'Vêtement supprimé !');
    }
}
