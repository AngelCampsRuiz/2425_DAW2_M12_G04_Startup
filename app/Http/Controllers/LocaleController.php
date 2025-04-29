<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class LocaleController extends Controller
{
    public function setLocale(Request $request)
    {
        $locale = $request->input('locale');
        $previousUrl = URL::previous();

        if (in_array($locale, ['es', 'en', 'ca'])) {
            // Establecer el idioma en la sesión
            Session::put('locale', $locale);

            // Establecer el idioma en la aplicación
            App::setLocale($locale);

            // Forzar que se guarde la sesión
            Session::save();

            // Crear una cookie con el idioma
            $cookie = cookie('locale', $locale, 60*24*365);

            Log::info('Locale set to: ' . $locale);
            Log::info('Session locale is: ' . Session::get('locale'));
            Log::info('App locale is: ' . App::getLocale());
            Log::info('Previous URL: ' . $previousUrl);

            if ($request->ajax()) {
                return response()->json(['success' => true, 'locale' => $locale])->withCookie($cookie);
            }

            return redirect($previousUrl)->withCookie($cookie);
        }

        if ($request->ajax()) {
            return response()->json(['success' => false]);
        }

        return redirect('/');
    }
}
