<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $hidden = ['pivot'];

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'category_id')->with('children');
    }

    public function parent() 
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function outfits()
    {
        return $this->belongsToMany(Outfit::class, 'category_outfits');
    }

    public function options(): BelongsToMany
    {
        return $this->belongsToMany(Option::class, 'category_options');
    }

    public function name()
    {
        if (app()->isLocale('en')) {
            return $this->name_en ?: $this->name;
        } else {
            return $this->name;
        }
    }
}
