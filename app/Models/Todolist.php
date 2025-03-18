<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Todolist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'desc',
        'is_done'
    ];

    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
