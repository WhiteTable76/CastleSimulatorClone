<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resources extends Model
{
    protected $fillable = ['user_id', 'wood', 'last_collected_at'];

    protected $casts = [
        'last_collected_at' => 'datetime',
    ];

    public function collectPendingResources(): void
    {
        $village = $this->user->village;

        $hoursPassed = $this->last_collected_at->diffInSeconds(now()) / 60;
        $woodGained = (int) floor($village->woodPerHour() * $hoursPassed);
        $stoneGained = (int) floor($village->stonePerHour() * $hoursPassed);
        $ironGained = (int) floor($village->ironPerHour() * $hoursPassed);


        if ($woodGained > 0)
         {
            $this->increment('wood', $woodGained);
         }

        if ($stoneGained > 0)
         {
            $this->increment('stone', $stoneGained);
         }

        if ($ironGained > 0)
         {
            $this->increment('iron', $ironGained);
         }

        $this->last_collected_at = now();
        $this->save();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
