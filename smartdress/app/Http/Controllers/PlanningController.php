<?php

namespace App\Http\Controllers;

use App\Models\Planning;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PlanningController extends Controller
{
    // Afficher la vue semaine
    public function index()
    {
        $startOfWeek = Carbon::now()->startOfWeek(); // Lundi
        $endOfWeek   = Carbon::now()->endOfWeek();   // Dimanche

        $plannings = Planning::with(['top.photos', 'bottom.photos'])
            ->where('user_id', auth()->id())
            ->whereBetween('date_planning', [$startOfWeek, $endOfWeek])
            ->get()
            ->groupBy(fn($p) => $p->date_planning->format('Y-m-d'));

        // Générer les 7 jours de la semaine
        $semaine = [];
        for ($i = 0; $i < 7; $i++) {
            $jour = $startOfWeek->copy()->addDays($i);
            $semaine[] = [
                'date'     => $jour->format('Y-m-d'),
                'label'    => ucfirst($jour->translatedFormat('l d M')),
                'tenues'   => $plannings->get($jour->format('Y-m-d'), collect()),
                'estAujourd' => $jour->isToday(),
            ];
        }

        return view('planning.index', compact('semaine'));
    }

    // Enregistrer une tenue depuis le dashboard
    public function store(Request $request)
    {
        // Support both names: vetement_top_id (form/controller standard) and top_id (JS/Fetch)
        if ($request->has('top_id') && !$request->has('vetement_top_id')) {
            $request->merge([
                'vetement_top_id' => $request->top_id,
                'vetement_bottom_id' => $request->bottom_id,
            ]);
        }

        $request->validate([
            'vetement_top_id'    => 'required|exists:vetements,id',
            'vetement_bottom_id' => 'required|exists:vetements,id',
            'date_planning'      => 'nullable|date',
        ]);

        Planning::create([
            'user_id'            => auth()->id(),
            'vetement_top_id'    => $request->vetement_top_id,
            'vetement_bottom_id' => $request->vetement_bottom_id,
            'date_planning'      => $request->date_planning ?? today(),
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Tenue ajoutée au planning du jour !']);
        }

        return back()->with('success', 'Tenue ajoutée au planning !');
    }

    // Supprimer une tenue du planning
    public function destroy(Planning $planning)
    {
        abort_if($planning->user_id !== auth()->id(), 403);
        $planning->delete();
        return back()->with('success', 'Tenue retirée du planning.');
    }
}