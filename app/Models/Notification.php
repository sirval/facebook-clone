<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'is_read'
    ];

    protected function getCreatedAtAttribute()
    {
        $notified_at = $this->attributes['created_at'];
        return Carbon::parse($notified_at)->diffForHumans();
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
