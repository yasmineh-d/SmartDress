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
        $request->validate([
            'vetement_id' => 'nullable|exists:vetements,id',
            'tenue_id'    => 'nullable|exists:tenues,id',
        ]);

        // Eviter les doublons
        $exists = Favoris::where('user_id', Auth::id())
            ->where('vetement_id', $request->vetement_id)
            ->where('tenue_id', $request->tenue_id)
            ->exists();

        if ($exists) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Déjà en favoris']);
            }
            return back()->with('error', 'Déjà en favoris.');
        }

        $favori = Favoris::create([
            'user_id'     => Auth::id(),
            'vetement_id' => $request->vetement_id,
            'tenue_id'    => $request->tenue_id,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'id' => $favori->id]);
        }
        return back()->with('success', 'Ajouté aux favoris.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        $favori = Favoris::findOrFail($id);

        if ($favori->user_id !== Auth::id()) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Forbidden'], 403);
            }
            abort(403);
        }

        $favori->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Retiré des favoris.');
    }
}
