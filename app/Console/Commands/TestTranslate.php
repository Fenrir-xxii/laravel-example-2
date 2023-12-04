<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Google\Cloud\Translate\V2\TranslateClient;
use App\Models\Survey;
use App\Services\TranslatorService;
class TestTranslate extends Command
{
    private TranslatorService $translatorService;

    public function __construct(TranslatorService $translatorService)
    {
        parent::__construct();
        $this->translatorService = $translatorService;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-translate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $translate = new TranslateClient([
        //     'keyFilePath' => 'laravel-test\example\config\laravel-test-405818-a6b746582629.json'
        // ]);
        // $text = "Hello World";
        // $result = $translate->translate($text, [
        //     'source' => 'en',
        //     'target' => 'uk'
        // ]);

        // var_dump($result);
        //
        $langs =['uk', 'en'];
        foreach(Survey::all() as $survey) {
            // $survey->search = null;
            if(empty($survey->search)){
                $survey->search = $this->translatorService->generateSearchTags($survey);
                $survey->save();
            }
        }


    }

}
