<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class VariationOption extends Model
{
    use HasFactory;
    public $timestamps = false;


    public function outfit_items(): BelongsToMany
    {
        return $this->belongsToMany(OutfitItem::class, 'product_configurations','va_op_id','ou_it_id');
    }



    public function variation(): BelongsTo
    {
        return $this->belongsTo(Variation::class);
    }
}
