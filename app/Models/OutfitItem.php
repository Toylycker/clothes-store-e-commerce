<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OutfitItem extends Model
{
    use HasFactory;

    public function outfit(): BelongsTo
    {
        return $this->belongsTo(Outfit::class);
    }

    public function variation_options(): BelongsToMany
    {
        return $this->belongsToMany(VariationOption::class, 'product_configurations', 'ou_it_id', 'va_op_id');
    }
}
