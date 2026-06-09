<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vetement extends Model
{
    protected $fillable = [
        'nom',
        'categorie',
        'couleur',
        'style',
        'user_id',
    ];

    /**
     * Charger automatiquement la relation saisons.
     */
    protected $with = ['saisons'];

    /**
     * Accesseur : Récupère la liste des noms des saisons associées.
     * Assure la compatibilité avec toutes les vues existantes.
     */
    public function getSaisonAttribute(): array
    {
        return $this->saisons->pluck('nom')->toArray();
    }

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

    /**
     * Relation Many-to-Many avec les Saisons.
     */
    public function saisons()
    {
        return $this->belongsToMany(Saison::class, 'saison_vetement');
    }
}