<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
//Every item should have it's own order(coz sellers are different) except for same seller with 2 or more items. In that case order number should be same.
{
    use HasFactory;

    protected $guarded = ['id'];

    public function outfitItems()
    {
        return $this->belongsToMany(OutfitItem::class, 'order_items');
        
    }

    public function user()
    {
        return $this->belongsTo(User::class);
        
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
        
    }

    public function deliveryProcesses()
    {
        return $this->hasMany(DeliveryProcess::class);
        
    }
}
