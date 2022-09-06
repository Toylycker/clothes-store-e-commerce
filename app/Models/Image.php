<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function outfit()
    {
        return $this->belongsTo(Outfit::class);
    }


    public function image()
    {
        if ($this->name) {
            return Storage::url('public/outfits/' . $this->name);
        } else {
            return asset('img/temp/outfit.jpg');
        }
    }
}