<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model
{
    protected $table = "blogs";

    protected $fillable = [
        'user_id',
        'unique_title',
        'title',
        'cover',
        'content'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id", "id", "users");
    }
}
