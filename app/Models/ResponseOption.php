<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseOption extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'survey_id',
        'image_id'
    ];
    public function image(){
        return $this->belongsTo(Image::class);
    }
    public function survey(){
        return $this->belongsTo(Survey::class);
    }
    public function votes(){
        return $this->hasMany(Vote::class);
    }
    protected $appends = array('votePercentage');


private $cached_votePercentage = null;
//then
public function getVotePercentageAttribute($votePercentage) : float{

    if ($this->cached_votePercentage === null) {
        $votePercentage = 0.0;
        $surveyVotesCount = $this->survey->votes()->count();
        $thisOptionVotesCount = $this->votes()->count();
        if($surveyVotesCount != 0){
            $votePercentage = round($thisOptionVotesCount / $surveyVotesCount, 2) * 100;
        }
       
        $this->cached_votePercentage = $votePercentage ;
    }
    
    
    return $this->cached_votePercentage;
}
}
