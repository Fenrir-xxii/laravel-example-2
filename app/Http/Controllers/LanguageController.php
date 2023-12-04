<?php
namespace App\Http\Controllers;
class LanguageController extends Controller 
{
    public function changeLanguage(string $language){
        // var_dump($language);
        // die();
        $languages = ['uk', 'en'];
        if(!in_array($language, $languages)){
            return response()->json(['ok' => false, 'language' => app()->getLocale(), 400]);
        }
        session(['language' => $language]);
        session()->put('locale', $language);
        return response()->json(['ok' => true, 'language' => $language]);

    }
}