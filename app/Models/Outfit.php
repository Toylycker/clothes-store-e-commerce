<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;


class Outfit extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    protected $hidden = ['pivot'];


    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'outfit_tags');
    }

    public function values()
    {
        return $this->belongsToMany(Value::class, 'outfit_values')->withPivot('quantity') ;
    }

    public function variations(): HasMany
    {
        return $this->hasMany(Variation::class);
    }

    public function outfit_items(): HasMany
    {
        return $this->hasMany(outfitItem::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_outfits');
    }

    public function ages()
    {
        return $this->belongsToMany(Age::class, 'outfit_ages')->withPivot('quantity');
    }

    public function name()
    {
        if (app()->isLocale('en')) {
            return $this->name_en ?: $this->name_tm;
        } else {
            return $this->name;
        }
    }

    public function description()
    {
        if (app()->isLocale('en')) {
            return $this->description_en ?: $this->description();
        } else {
            return $this->description;
        }
    }

    public function image()
    {
        if ($this->image) {
            return Storage::url('public/outfits/' . $this->image);
        } else {
            return asset('img/temp/outfit.png');
        }
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function orderitems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
