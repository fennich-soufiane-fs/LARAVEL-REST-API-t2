<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logging extends Model
{
    protected $fillable = [
        'user_id',
        'ip_address',
        'message',
        'action'
    ];

    public static function record($user = null, $message) {
        return static::create([
            'user_id' => $user,
            'ip_address' => request()->ip(),
            'message' => $message,
            'action' => request()->fullUrl()
        ]);
    }
}
