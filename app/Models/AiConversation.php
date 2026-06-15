<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiConversation extends Model
{
    protected $fillable = [
        'user_id','session_id','messages',
        'detected_mood','detected_emoji','suggested_foods'
    ];

    protected $casts = [
        'messages'       => 'array',
        'suggested_foods'=> 'array',
    ];

    public function user() { return $this->belongsTo(User::class); }
}
