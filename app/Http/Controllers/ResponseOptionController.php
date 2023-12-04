<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\ResponseOption;
use App\Services\TranslatorService;

class ResponseOptionController extends Controller
{
    private TranslatorService $translatorService;
    public function __construct(TranslatorService $translatorService)
    {
        $this->translatorService = $translatorService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Survey $survey)
    {
        return view('responseOption.index', [
            'survey' => $survey,
            'options' => ResponseOption::where('survey_id', $survey->id)->get(),
            't' => $this->translatorService
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Survey $survey) 
    {
        // var_dump($survey); die();
        return view('responseOption.create' , [
            'survey' => $survey
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Survey $survey)
    {
        ResponseOption::create([
            'title' => $request->title,
            'survey_id' => $survey->id,
        ]);
        return redirect()->route('options.index', [$survey]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ResponseOption $option)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResponseOption $option)
    {

        return view('responseOption.edit', [
            'model' => $option,
            'survey' => Survey::find($option->survey_id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ResponseOption $option)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255']
        ]);
        // var_dump($option);
        // die();
        $option->title = $request->title;
        // var_dump($survey);
        // die();
        $option->save();
        $survey = Survey::find($option->survey_id);
        return redirect()->route('options.index', [$survey]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResponseOption $option)
    {
        ResponseOption::destroy($option->id);
        $survey = Survey::find($option->survey_id);
        return redirect()->route('surveys.index', [$survey]);
    }
}
