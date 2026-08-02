<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $fillable = ['user_id', 'logging_site_level'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
