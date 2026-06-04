<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    protected $fillable = [
        'user_id',
        'vetement_top_id',
        'vetement_bottom_id',
        'date_planning',
    ];

    protected $casts = [
        'date_planning' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function top()
    {
        return $this->belongsTo(Vetement::class, 'vetement_top_id');
    }

    public function bottom()
    {
        return $this->belongsTo(Vetement::class, 'vetement_bottom_id');
    }
}