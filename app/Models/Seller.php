<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public $timestamps = false;

    protected $hidden = ['pivot'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function outfits()
    {
        return $this->hasMany(Outfit::class);
    }

    public function name()
    {
        if (app()->isLocale('en')) {
            return $this->name_en ?: $this->name_tm;
        } else {
            return $this->name;
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
