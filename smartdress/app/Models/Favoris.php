<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favoris extends Model
{
    protected $fillable = [
        'user_id',
        'vetement_id',
        'tenue_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vetement()
    {
        return $this->belongsTo(Vetement::class);
    }

    public function tenue()
    {
        return $this->belongsTo(Tenue::class);
    }
}
