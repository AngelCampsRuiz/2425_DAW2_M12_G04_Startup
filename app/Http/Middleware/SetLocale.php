<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Intentar obtener el idioma de diferentes fuentes en orden de prioridad
        $locale = Session::get('locale') ??
                 $request->cookie('locale') ??
                 config('app.locale');

        // Verificar que el idioma sea válido
        if (in_array($locale, ['es', 'en', 'ca'])) {
            App::setLocale($locale);
            Session::put('locale', $locale);

            // Log para debugging
            Log::info('Middleware SetLocale - Current locale: ' . App::getLocale());
            Log::info('Middleware SetLocale - Session locale: ' . Session::get('locale'));
            Log::info('Middleware SetLocale - Cookie locale: ' . $request->cookie('locale'));
            Log::info('Middleware SetLocale - Config locale: ' . config('app.locale'));
        }

        return $next($request);
    }
}
