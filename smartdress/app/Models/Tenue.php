<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenue extends Model
{
    protected $fillable = [
        'nom',
        'meteo_adaptee',
        'conseil_ia',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vetements()
    {
        return $this->belongsToMany(Vetement::class, 'tenue_vetement');
    }
}
