<?php

namespace App\Http\Controllers;

use App\Models\Favoris;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavorisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $favoris = Auth::user()->favoris()->with(['vetement', 'tenue'])->get();
        return view('favoris.index', compact('favoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vetement_id' => 'nullable|exists:vetements,id',
            'tenue_id' => 'nullable|exists:tenues,id',
        ]);

        if (is_null($validated['vetement_id']) && is_null($validated['tenue_id'])) {
            return back()->with('error', 'Veuillez sélectionner un vêtement ou une tenue.');
        }

        Auth::user()->favoris()->create($validated);

        return back()->with('success', 'Ajouté aux favoris !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $favori = Favoris::findOrFail($id);

        if ($favori->user_id !== Auth::id()) {
            abort(403);
        }

        $favori->delete();

        return back()->with('success', 'Retiré des favoris.');
    }
}
