<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;
use App\Http\Requests\SurveyRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use App\Models\ResponseOption;
use App\Services\TranslatorService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Lang;

class SurveyController extends Controller
{
    private TranslatorService $translatorService;
    public function __construct(TranslatorService $translatorService)
    {
        $this->translatorService = $translatorService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $models = Survey::query()->where('search', 'like', '%' . $search . '%')->get();

        return view('survey.index', [
            'models' => $models,
            't' => $this->translatorService,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('survey.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SurveyRequest $request)
    {
        $image = $request->upload();
        // if($image){
        //     // Image::create([
        //     //     'filename' => $image->filename,
        //     // ]);
        // }
        $survey = new Survey();
        $survey->title = $request->title;
        $survey->description = $request->description;
        $searchTags = $this->translatorService->generateSearchTags($survey);
        // var_dump($searchTags); die();
            //throw new \Exception("error controller");
        Survey::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'active' => $request->has('active'),
            'image_id' => $image == null ? null : $image->id,
            'user_id' => $request->user()->id,
            'search' => $searchTags
        ]);
        return redirect()->route('surveys.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Survey $survey)
    {
        $options = $survey->options()->pluck('title');
        $translated = [];
        foreach ($options as $opt){
            $translated[] = $this->translatorService->translate($opt, Lang::getLocale());
        }
        // $translated = $this->translatorService->translate($options, Lang::getLocale());
        // var_dump($translated);
        // die();
        return view('survey.show', [
            'model' => $survey,
            // 'labels' => ResponseOption::where('survey_id', '=', $survey->id)->pluck('title'),
            'labels' => $translated,
            't' => $this->translatorService
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Survey $survey)
    {

        return view('survey.edit', [
            'model' => $survey,
            // 'options' => ResponseOption::where('survey_id', $survey->id)->get(),
            't' => $this->translatorService
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SurveyRequest $request, Survey $survey)
    {
        // var_dump($request);
        $checked =  $request->has('active');
        // var_dump($checked);
        $survey->active = $checked;
        $survey->fill($request->validated());
        $survey->search = $this->translatorService->generateSearchTags($survey);

        $image = $request->upload();
        $oldImage = null;
        if ($image) {
            if ($survey->image) {
                $oldImage = $survey->image;
                // Storage::disk('images')->delete($survey->image->filename);
                // $survey->image->delete();
            }
            $survey->image_id = $image->id;
            // $survey->image()->associate($image);
        }

        // var_dump($survey);
        // die();
        $survey->save();
        if ($oldImage !== null) {
            $oldImage->delete();
        }
        return redirect()->route('surveys.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Survey $survey)
    {
        Survey::destroy($survey->id);
        return redirect()->route('surveys.index');
    }
}
