<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Value extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public $timestamps = false;

    protected $hidden = ['pivot'];


    public function outfits()
    {
        return $this->belongsToMany(Outfit::class, 'outfit_values');
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function name()
    {
        if (app()->isLocale('en')) {
            return $this->name_en ?: $this->name_tm;
        } else {
            return $this->name;
        }
    }
}
