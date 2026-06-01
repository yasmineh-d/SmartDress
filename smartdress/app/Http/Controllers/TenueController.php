<?php

namespace App\Http\Controllers;

use App\Models\Tenue;
use App\Services\TenueService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenueController extends Controller
{
    public function __construct(
        private readonly TenueService $tenueService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenues = $this->tenueService->getForUser(Auth::user());

        return view('tenues.index', compact('tenues'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vetements = $this->tenueService->getAvailableClothesForUser(Auth::user());

        return view('tenues.create', compact('vetements'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'meteo_adaptee' => 'nullable|string',
            'conseil_ia' => 'nullable|string',
            'vetements' => 'nullable|array',
            'vetements.*' => 'exists:vetements,id',
        ]);

        $this->tenueService->createForUser(Auth::user(), $validated);

        return redirect()->route('tenues.index')->with('success', 'Tenue créée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenue $tenue)
    {
        return view('tenues.show', compact('tenue'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenue $tenue)
    {
        $vetements = $this->tenueService->getAvailableClothesForUser(Auth::user());

        return view('tenues.edit', compact('tenue', 'vetements'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenue $tenue)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'meteo_adaptee' => 'nullable|string',
            'conseil_ia' => 'nullable|string',
            'vetements' => 'nullable|array',
            'vetements.*' => 'exists:vetements,id',
        ]);

        $this->tenueService->update($tenue, $validated);

        return redirect()->route('tenues.index')->with('success', 'Tenue mise à jour !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenue $tenue)
    {
        $this->tenueService->delete($tenue);

        return redirect()->route('tenues.index')->with('success', 'Tenue supprimée !');
    }
}
