<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'title',
        'text',
        'recommended',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
