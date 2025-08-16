<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier s'il y a un paramètre lang dans l'URL
        if ($request->has('lang')) {
            $locale = $request->get('lang');
            if (in_array($locale, ['fr', 'en', 'it'])) {
                App::setLocale($locale);
                Cookie::queue('locale', $locale, 60 * 24 * 30); // 30 jours
                return $next($request);
            }
        }

        // Sinon, vérifier le cookie
        $locale = Cookie::get('locale');
        if ($locale && in_array($locale, ['fr', 'en', 'it'])) {
            App::setLocale($locale);
        } else {
            // Langue par défaut
            App::setLocale('fr');
        }

        return $next($request);
    }
}
