<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStreak extends Model
{
    protected $table = 'user_streaks';

    protected $fillable = [
        'user_id',
        'streak',
        'last_date',
    ];

    protected $casts = [
        'streak' => 'integer',
        'last_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
