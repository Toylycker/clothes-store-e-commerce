<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Variation extends Model
{
    use HasFactory;
    public $timestamps = false;


    public function outfit(): BelongsTo
    {
        return $this->belongsTo(Outfit::class);
    }

    public function variation_options(): HasMany
    {
        return $this->hasMany(VariationOption::class);
    }
}
