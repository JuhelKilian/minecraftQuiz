<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mot;
class MotController extends Controller
{
    public function index(Request $request)
    {
        $query = Mot::orderBy('difficulte')->orderBy('name_fr');

        // Recherche globale
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name_fr', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('name_en', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('name_it', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filtre par difficulté
        if ($request->filled('difficulte')) {
            $query->where('difficulte', $request->difficulte);
            $mots = $query->paginate(50);
        } else {
            $mots = $query->paginate(50);
        }

        return view('mots.index', compact('mots'));
    }

    public function updateLearningLanguage(Request $request)
    {
        session(['learning_language' => $request->learning_language]);
        return response()->json(['success' => true]);
    }
}
