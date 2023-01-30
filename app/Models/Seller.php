<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public $timestamps = false;

    protected $hidden = ['pivot'];

    protected $fillable = [
        'user_id',
        'location_id',
    'seller_name',
    'seller_last_name',
    'seller_phone',
    'shop_address',
    'company_name'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function outfits()
    {
        return $this->hasMany(Outfit::class);
    }

    // so that we can group items by its seller in shopcart because location and posession of that items are from sm eplace 
    public function shopCarts()
    {
        return $this->hasMany(shopCarts::class);
    }

    //So that we can see customers' orders from this seller
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function name()
    {
        if (app()->isLocale('en')) {
            return $this->name_en ?: $this->name_tm;
        } else {
            return $this->name;
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
