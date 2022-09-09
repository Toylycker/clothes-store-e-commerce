<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Age extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public $timestamps = false;

    protected $hidden = ['pivot'];

    public function name()
    {
        if (app()->isLocale('en')) {
            return $this->name_en ?: $this->name;
        } else {
            return $this->name;
        }
    }

    public function description()
    {
        if (app()->isLocale('en')) {
            return $this->description_en ?: $this->description;
        } else {
            return $this->description;
        }
    }

    public function outfits()
    {
        return $this->belongsToMany(Outfit::class, 'outfit_ages')->withPivot('quantity');
    }
}
