<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use App\Services\TranslatorService;
use Tests\TestCase;
use App\Models\Survey;

class TranslatorServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_instance(): void
    {
         /**
         * @var TranslatorService $translator
         */
        $translator = app()->get(TranslatorService::class);
        $this->assertInstanceOf(TranslatorService::class, $translator);
    }
    public function test_translate(): void
    {
         /**
         * @var TranslatorService $translator
         */
        $translator = app()->get(TranslatorService::class);
        $this->assertEquals('Тест', $translator->translate('Test', 'uk'));
    }
    public function test_survey_search(): void
    {
        /**
         * @var TranslatorService $translator
         */
        $translator = app()->get(TranslatorService::class);
        $survey = new Survey(['title' => 'Apple']);
        $search = $translator->generateSearchTags($survey);
        
        $this->assertStringContainsStringIgnoringCase('Яблуко', $search);
    }
}
