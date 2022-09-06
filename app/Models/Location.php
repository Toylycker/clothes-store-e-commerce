<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public $timestamps = false;

    protected $hidden = ['pivot'];


    public function sellers()
    {
        return $this->hasMany(Seller::class);
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
