<?php

namespace App\Services;
use Illuminate\Support\Facades\Cache;
use Google\Cloud\Translate\V2\TranslateClient;
use App\Models\Survey;

/**
 * Class TranslatorService.
 */
class TranslatorService
{
    private string $keyFilePath;
    private TranslateClient $client;
    public function __construct(string $keyFilePath)
    {
        $this->keyFilePath = $keyFilePath;
        $this->client = new TranslateClient([
            'keyFilePath' => $this->keyFilePath
        ]);
    }
    //private $cache = 

    public function translate(string $text, string $to): string {

        $cacheKey = sha1(json_encode([$to, $text]));

        return Cache::rememberForever($cacheKey, function () use ($text, $to) {
            $result = $this->client->translate($text, [
                //'source' => 'en',
                'target' => $to,
            ]);

            return $result['text'];
        });
    }
    public function generateSearchTags(Survey $survey): string{
        $langs =['uk', 'en'];
        $title = $survey->title;
        // $description = $survey->description;
        $result = $title;// . ' ' . $description;
        foreach($langs as $lang){
            $result .= ' ' . $this->translate($title, $lang);
            // $result .= ' ' . $this->translate($description, $lang);
        }
        return $result;
    }
}
