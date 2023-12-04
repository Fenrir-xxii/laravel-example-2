<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'survey_id',
        'response_option_id',
        'user_id',
        'voted_at'
    ];
    public function getDates()
    {
        return [
            'voted_at'
        ];
    }
    public function options(){
        return $this->belongsTo(ResponseOption::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
