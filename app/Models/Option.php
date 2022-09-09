<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Option extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public $timestamps = false;

    protected $hidden = ['pivot'];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(category::class, 'category_options');
    }


    public function values()
    {
        return $this->hasMany(Value::class)
        ->orderBy('sort_order')
        ->orderBy('name');
        
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
