<?php

namespace App\Models;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $filename
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Image extends Model
{
    protected $table = 'images';

    protected $fillable = [
        'filename'
    ];
    public static function booted()
    {
        static::deleted(function (Image $image) {  // after delete
            Storage::disk('images')->delete($image->filename);
        });
    }
}
