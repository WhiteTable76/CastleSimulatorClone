<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuildingUpgrade extends Model
{
    protected $fillable = ['village_id', 'building_type', 'ends_at'];

    protected $casts = [
        'ends_at' => 'datetime',
    ];

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
