<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LanguageControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_language_uk(): void
    {
        $lang = 'uk';
        $content = $this->get('/change-language/' . $lang);
        $content->assertStatus(200)->assertExactJson([
            'ok' => true,
            'language' => $lang
        ]);
    }
    public function test_language_en(): void
    {
        $lang = 'en';
        $content = $this->get('/change-language/' . $lang);
        $content->assertStatus(200)->assertExactJson([
            'ok' => true,
            'language' => $lang
        ]);
    }
    public function test_language_not_existing_lang(): void
    {
        $lang = 'rand';
        $content = $this->get('/change-language/' . $lang);
        $content->assertStatus(200)->assertExactJson([
            'ok' => false,
            'language' => app()->getLocale(),
            400
        ]);
    }
}
