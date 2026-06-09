<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saison extends Model
{
    protected $fillable = ['nom'];

    /**
     * Relation avec les vêtements.
     */
    public function vetements()
    {
        return $this->belongsToMany(Vetement::class, 'saison_vetement');
    }
}
