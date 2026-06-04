<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vetement extends Model
{
    protected $fillable = [
        'nom',
        'categorie',
        'couleur',
        'saison', // Ton champ existant
        'style',
        'user_id',
    ];

    // On ajoute le cast ici pour transformer automatiquement la chaîne JSON en tableau PHP
    protected $casts = [
        'saison' => 'array',
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