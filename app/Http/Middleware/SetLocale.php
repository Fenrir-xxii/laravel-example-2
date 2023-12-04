<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class SetLocale
{
    const SESSION_KEY = 'locale';
    const LOCALES = ['uk', 'en'];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $session = $request->getSession();
        // var_dump($session);
        // die();

        // $language = $request->session()->get('language');
        // if ($language !== null) {
        //     app()->setLocale($language);
        //     return $next($request);
        // }
        // var_dump($language);
        // die();
        $userLocales = $request->getLanguages();
        foreach ($userLocales as $lang) {
            if (in_array($lang, self::LOCALES)) {
                app()->setLocale($lang);
                $request->session()->put('locale', $lang);
                // session(['language' => $lang]);
                break;
            }
        }

        if ($request->session()->has('language')) {
            // $a = $request->session()->get('language');
            // var_dump($request->session());
            // die();
            app()->setLocale(session()->get('language'));
            // return $next($request);
        }
        // else{
        //     $userLocales = $request->getLanguages();
        //     // var_dump($userLocales);
        //     // die();
        //     foreach ($userLocales as $lang) {
        //         if (in_array($lang, self::LOCALES)) {
        //             app()->setLocale($lang);
        //             $request->session()->put('locale', $lang);
        //             // session(['language' => $lang]);
        //             break;
        //         } else {
        //             app()->setLocale(self::LOCALES[0]);
        //             // $request->session()->put('locale', self::LOCALES[0]);
        //         }
        //     }
        // }



        // $userLocales = $request->getLanguages();
        // // var_dump($userLocales);
        // // die();
        // foreach ($userLocales as $lang) {
        //     if (in_array($lang, self::LOCALES)) {
        //         app()->setLocale($lang);
        //         // $request->getSession()::push('locale', $lang);
        //         // session(['language' => $lang]);
        //         break;
        //     } else {
        //         app()->setLocale(self::LOCALES[0]);
        //     }
        // }
        return $next($request);
    }
}
// class SetLocale
// {
//     /**
//      * Handle an incoming request.
//      *
//      * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
//      */
//     public function handle(Request $request, Closure $next): Response
//     {
//         $language = $request->session()->get('language');
//         if($language !== null){
//             app()->setLocale($language);
//         }
//         return $next($request);
//     }
// }
