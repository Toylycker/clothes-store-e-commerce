<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $timestamps = false;

    public function seller()
    {
        return $this->hasOne(Seller::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
        
    }

    public function shopCarts()
    {
        return $this->hasMany(ShopCart::class);
        
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function chats()
    {
        return $this->belongsToMany(Chat::class, 'chat_users');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'from_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'to_id');
    }
}
