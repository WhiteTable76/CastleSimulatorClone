<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $fillable = ['user_id', 'logging_site_level'];

    protected static array $BazowyKoszt = [
        'logging_site' => ['wood' => 50]
    ];

    protected float $multiplier = 1.5;

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function KosztUlepszenia(): array{

        $base = self::$BazowyKoszt[$this->type] ?? ['wood' => 0];
        $factor = $this->multiplier ** ($this->level - 1);

        return [
            'wood' => (int) round($base['wood'] * $factor)
        ];
    }

}
