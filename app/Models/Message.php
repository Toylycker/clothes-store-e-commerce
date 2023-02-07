<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['chat_id', 'from_id', 'to_id', 'content'];


    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    public function receiever(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_id');
    }

    public function outfit(): BelongsTo
    {
        return $this->belongsTo(Outfit::class);
    }
}
