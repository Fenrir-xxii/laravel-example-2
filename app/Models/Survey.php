<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string|null $search
 * @property Carbon|null $start_at
 * @property Carbon|null $end_at
 * @property int|null $image_id
 * @property int $user_id
 * @property bool $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Image $image
 * @property User $user
 */
class Survey extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'start_at',
        'end_at',
        'user_id',
        'image_id',
        'active',
        'search'
    ];
    public function getDates()
    {
        return [
            'start_at',
            'end_at',
            'updated_at',
            'created_at'
        ];
    }
    protected $casts = [
        'active' => 'boolean',
        // 'start_at' => 'date',
        // 'end_at' => 'date'
    ];
    public function image()
    {
        return $this->belongsTo(Image::class);
    }
    public function options(){
        return $this->hasMany(ResponseOption::class);
    }
    public function votes(){
        return $this->hasMany(Vote::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

}
