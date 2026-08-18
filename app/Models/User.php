<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'player_name', 'experience'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function resources()
    {
        return $this->hasOne(Resources::class);
    }

        public function village()
    {
        return $this->hasOne(Village::class);
    }


    protected static int $baseXp = 100;
    protected static float $xpExponent = 1.5;

    public function level(): int
    {
    $level = 1;

    while ($this->experience >= $this->xpRequiredForLevel($level + 1)) {
        $level++;
    }

    return $level;
    }

    public function xpRequiredForLevel(int $level): int
    {
    if ($level <= 1) {
        return 0;
    }

    return (int) round(self::$baseXp * ($level ** self::$xpExponent));
    }

    public function xpProgressToNextLevel(): array
    {
    $currentLevel = $this->level();
    $currentThreshold = $this->xpRequiredForLevel($currentLevel);
    $nextThreshold = $this->xpRequiredForLevel($currentLevel + 1);

    return [
        'current' => $this->experience - $currentThreshold,
        'needed' => $nextThreshold - $currentThreshold,
    ];
}

    public function addExperience(int $amount): void
    {
    $levelBefore = $this->level();

    $this->increment('experience', $amount);

    $levelAfter = $this->fresh()->level();

    if ($levelAfter > $levelBefore) {
        event(new \App\Events\PlayerLeveledUp($this, $levelBefore, $levelAfter));
    }
    }



}

