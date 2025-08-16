<?php
// Créez app/Http/Controllers/LanguageController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function changeLanguage(Request $request)
    {
        $language = $request->input('language');

        // Mapping des codes courts vers les codes de session
        $languageMapping = [
            'fr_fr' => 'fr_fr',
            'en_us' => 'en_us',
            'it_it' => 'it_it'
        ];

        // Validation et conversion
        if (array_key_exists($language, $languageMapping)) {
            $sessionLanguage = $languageMapping[$language];
            session(['language' => $sessionLanguage]);

            return response()->json([
                'success' => true,
                'language' => 'Langue non supportée'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $language
        ], 400);
    }

    /**
     * Obtenir la langue courante depuis la session
     */
    public static function getCurrentLanguage()
    {
        return session('language', 'fr_fr'); // fr_fr par défaut
    }

    /**
     * Mapping pour les drapeaux et codes affichage
     */
    public static function getLanguageDisplay($sessionLang = null)
    {
        $sessionLang = $sessionLang ?: self::getCurrentLanguage();

        $mapping = [
            'fr_fr' => ['flag' => '🇫🇷', 'code' => 'FR', 'short' => 'fr'],
            'en_us' => ['flag' => '🇬🇧', 'code' => 'EN', 'short' => 'en'],
            'it_it' => ['flag' => '🇮🇹', 'code' => 'IT', 'short' => 'it']
        ];

        return $mapping[$sessionLang] ?? $mapping['fr_fr'];
    }
}
