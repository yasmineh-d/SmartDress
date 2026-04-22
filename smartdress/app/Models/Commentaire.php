<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    protected $fillable = [
        'contenu',
        'user_id',
        'tenue_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tenue()
    {
        return $this->belongsTo(Tenue::class);
    }
}
