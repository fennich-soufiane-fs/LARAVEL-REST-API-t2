<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Todolist extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'desc',
        'is_done'
    ];
}
