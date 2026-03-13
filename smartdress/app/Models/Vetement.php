<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vetement extends Model
{
    protected $fillable = [
        'nom',
        'categorie',
        'couleur',
        'saison',
        'style',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function tenues()
    {
        return $this->belongsToMany(Tenue::class, 'tenue_vetement');
    }
}
