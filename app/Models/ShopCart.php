<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopCart extends Model
{
    public $timestamps = false;
    protected $fillable = ['user_id', 'seller_id'];
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // so that we can group items by its seller in shopcart because location and posession of that items are from sm eplace 
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function outfitItems()
    {
        return $this->belongsToMany(OutfitItem::class, 'shop_cart_items')->withPivot('quantity');
    }
}
