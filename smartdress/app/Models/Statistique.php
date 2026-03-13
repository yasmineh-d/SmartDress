<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistique extends Model
{
    protected $fillable = [
        'total_vetements',
        'total_tenues',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
