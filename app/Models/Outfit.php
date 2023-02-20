<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;

class Outfit extends Model
{
    use HasFactory, Searchable;

    protected $guarded = ['id'];


    protected $hidden = ['pivot'];
    protected $fillable = ['image', 'name', 'description', 'confirmed', 'search'];


    public function toSearchableArray()
{
    return [
        'id' => (int) $this->id,
        'name' => $this->name,
        'search' => $this->search,
        'category_id' => (int) $this->category_id,
    ];
}
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'outfit_tags');
    }

    public function values()
    {
        return $this->belongsToMany(Value::class, 'outfit_values');
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

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
