<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\ResponseOption;
use Illuminate\Support\Facades\Auth;
use App\Services\TranslatorService;
use Bihan\AboutMe\Models\User;

class VoteController extends Controller
{
    private TranslatorService $translatorService;
    public function __construct(TranslatorService $translatorService)
    {
        $this->translatorService = $translatorService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $myCompleetdSurveysId = Vote::where('user_id', Auth::id())->get();
        $myCompleetdSurveysId = Vote::where('user_id', Auth::id())->pluck('survey_id');
        // $myCompleetdSurveysId = Vote::select('survey_id')->where('user_id', Auth::id())->get();
        if($myCompleetdSurveysId->count() == 0){ 
            $myCompleetdSurveysId[] = -1; //CHANGE
        }
        // var_dump($myCompleetdSurveysId);
        // die();
        // $a = Vote::where('user_id', Auth::id())->get();
        // var_dump($a);
        // die();
        return view('vote.index', [
            'available_surveys' => Survey::where('end_at', '>=', date('Y-m-d H:i'))->where('active', 1)->whereNotIn('id', $myCompleetdSurveysId)->get(),
            'finished_surveys' => Survey::where('end_at', '<=', date('Y-m-d H:i'))->get(),
            'completed_surveys' => Survey::whereIn('id', $myCompleetdSurveysId)->get(),
            'all_user_votes' => Vote::where('user_id', Auth::id())->get(),
            'all_options' => ResponseOption::all(),
            'all_surveys' => Survey::all(),
            't' => $this->translatorService
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Survey $survey)
    {
        return view('vote.create',[
            'survey' => $survey,
            'options' => ResponseOption::where('survey_id', $survey->id)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $optionId = request('selected_option');
        $responseOption = ResponseOption::where('id', $optionId)->first();
        // var_dump($optionId);
        // die();
        if($this->checkVotePossibility($responseOption)){
            $vote = new Vote();
            $vote->user_id = Auth::id();
            $vote->survey_id = Survey::find($responseOption->survey_id)->id;
            $vote->response_option_id = $responseOption->id;
            $vote->voted_at = date('Y-m-d H:i:s');
            // var_dump($vote);
            // die();
    
            $vote->save();
        }
       
        return redirect()->route('voting.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vote $vote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vote $vote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vote $vote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vote $vote)
    {
        //
    }
    public function checkVotePossibility(ResponseOption $option) : bool{
        // $user = User::where('id', Auth::id())->get();
        $votes = $option->votes()->where('user_id', Auth::id())->get();
        if(count($votes) > 0){
            return false;
        }
        return true;
    }
}
