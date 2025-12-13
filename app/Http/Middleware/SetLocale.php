<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
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
        $locale = $this->getLocale($request);

        // Set the application locale
        App::setLocale($locale);

        // Store in session for future requests
        if ($request->hasSession()) {
            Session::put('locale', $locale);
        }

        return $next($request);
    }

    /**
     * Determine the locale from various sources
     */
    protected function getLocale(Request $request): string
    {
        $availableLocales = config('app.available_locales') ?? ['en', 'ar'];

        // 1. Check query parameter (?lang=ar)
        if ($request->has('lang') && in_array($request->query('lang'), $availableLocales)) {
            return $request->query('lang');
        }

        // 2. Check custom header (X-Locale)
        if ($request->hasHeader('X-Locale') && in_array($request->header('X-Locale'), $availableLocales)) {
            return $request->header('X-Locale');
        }

        // 3. Check Accept-Language header
        $acceptLanguage = $request->header('Accept-Language');
        if ($acceptLanguage) {
            $preferredLanguage = substr($acceptLanguage, 0, 2);
            if (in_array($preferredLanguage, $availableLocales)) {
                return $preferredLanguage;
            }
        }

        // 4. Check session
        if ($request->hasSession() && Session::has('locale')) {
            $sessionLocale = Session::get('locale');
            if (in_array($sessionLocale, $availableLocales)) {
                return $sessionLocale;
            }
        }

        // 5. Check authenticated user preference (if you have a locale column in users table)
        if ($request->user() && isset($request->user()->locale)) {
            if (in_array($request->user()->locale, $availableLocales)) {
                return $request->user()->locale;
            }
        }

        // 6. Default locale
        return config('app.locale', 'en');
    }
}
