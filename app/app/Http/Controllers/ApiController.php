<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function getData()
    {
        $data = [];
        $error = null;

        try {
            // Development fallback: skip local CA validation on this machine.
            $response = Http::withoutVerifying()->timeout(10)->get('https://fakestoreapi.com/products');

            if ($response->successful()) {
                $data = $response->json();
            } else {
                $error = 'Impossible de recuperer les produits pour le moment.';
            }
        } catch (\Exception $e) {
            $error = 'Erreur lors de la connexion a l API : '.$e->getMessage();
        }

        return view('welcome', compact('data', 'error'));
    }
}
