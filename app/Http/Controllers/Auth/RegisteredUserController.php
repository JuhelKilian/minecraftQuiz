<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
// use App\Providers\RouteServiceProvider; // Supprimé car non trouvé
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nomFamille' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'langue' => ['required', 'string', 'in:fr_fr,en_us,it_it'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Déterminer la langue par défaut basée sur la locale actuelle si non fournie
        $langue = $request->langue;
        if (!$langue) {
            $locale = app()->getLocale();
            $langue = match($locale) {
                'en' => 'en_us',
                'it' => 'it_it',
                default => 'fr_fr'
            };
        }

        $user = User::create([
            'name' => $request->name,
            'nomFamille' => $request->nomFamille,
            'email' => $request->email,
            'langue' => $langue,
            'nbJoursTravailles' => 0,
            'nbLeconsRealisees' => 0,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->intended('/dashboard');
    }
}
