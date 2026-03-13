<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'url',
        'dateUpload',
        'vetement_id',
    ];

    public function vetement()
    {
        return $this->belongsTo(Vetement::class);
    }
}
