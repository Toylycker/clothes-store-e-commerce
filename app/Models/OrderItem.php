<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(Order::class);
        
    }

    public function outfit()
    {
        return $this->belongsTo(Outfit::class);
        
    }
}
