<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $fillable = ['user_id', 'logging_site_level', 'stone_quarry_level','iron_mine_level'];

protected static array $buildingConfig = [
    'logging_site' => [
        'base_cost' => ['wood' => 50],
        'cost_multiplier' => 1.5,
        'base_duration' => 30,
        'duration_multiplier' => 1.3,
    ],
    'stone_quarry' => [
        'base_cost' => ['wood' => 40],
        'cost_multiplier' => 1.5,
        'base_duration' => 35,
        'duration_multiplier' => 1.3,
        'extra_cost_from_level' => [
            5 => ['iron' => 30],
        ],
    ],
    'iron_mine' => [
        'base_cost' => ['wood' => 60],
        'cost_multiplier' => 1.5,
        'base_duration' => 40,
        'duration_multiplier' => 1.3,
    ],
    'town_hall' => [
        'base_cost' => ['wood' => 100, 'stone' => 100],
        'cost_multiplier' => 1.6,
        'base_duration' => 30,
        'duration_multiplier' => 1.3,
        'duration_factor' => 4,
    ],
];

    protected float $multiplier = 1.5;
    protected float $durationMultiplier = 1.3;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function upgrades()
    {
        return $this->hasMany(BuildingUpgrade::class);
    }


public function kosztUlepszenia(string $buildingType): array
{
    $config = self::$buildingConfig[$buildingType];
    $targetLevel = $this->{$buildingType . '_level'} + 1;

    $cost = [];
    foreach ($config['base_cost'] as $resource => $baseAmount) {
        $factor = $config['cost_multiplier'] ** ($targetLevel - 1);
        $cost[$resource] = (int) round($baseAmount * $factor);
    }

    if (isset($config['extra_cost_from_level'])) {
        foreach ($config['extra_cost_from_level'] as $unlockLevel => $extraResources) {
            if ($targetLevel >= $unlockLevel) {
                foreach ($extraResources as $resource => $amount) {
                    $cost[$resource] = ($cost[$resource] ?? 0) + $amount;
                }
            }
        }
    }

    return $cost;
}

public function czasUlepszenia(string $buildingType): int
{
    $config = self::$buildingConfig[$buildingType];
    $targetLevel = $this->{$buildingType . '_level'} + 1;

    $factor = $config['duration_multiplier'] ** ($targetLevel - 1);
    $duration = $config['base_duration'] * $factor;

    if (isset($config['duration_factor'])) {
        $duration *= $config['duration_factor'];
    }

    return (int) round($duration);
}


    public function maxRownoczesnychUlepszen(): int
    {
        return 1;
    }

    public function czyMozeZaczacUlepszanie(): bool
    {
        return $this->upgrades()->count() < $this->maxRownoczesnychUlepszen();
    }


    public function czyUlepszaSie(string $buildingType): bool
    {
        return $this->upgrades()->where('building_type', $buildingType)->exists();
    }

    public function kiedyKoniecUlepszania(string $buildingType)
    {

    $upgrade = $this->upgrades()->where('building_type', $buildingType)->first();

    return $upgrade?->ends_at;
    }

    public function rozpocznijUlepszanie(string $buildingType): void
    {
        $duration = $this->czasUlepszenia($buildingType);

        $this->upgrades()->create([
            'building_type' => $buildingType,
            'ends_at' => now()->addSeconds($duration),
        ]);
    }

    public function finalizujZakonczoneUlepszenia(): void
    {
        $zakonczone = $this->upgrades()->where('ends_at', '<=', now())->get();

        foreach ($zakonczone as $upgrade) {
            $column = $upgrade->building_type . '_level';
            $this->increment($column);
            $upgrade->delete();
        }
    }




    protected static float $productionBase = 20;
    protected float $productionMultiplier = 1.2;

    public function woodPerHour(): float
    {
        return self::$productionBase * ($this->productionMultiplier ** ($this->logging_site_level - 1));
    }

    public function stonePerHour(): float
    {
        return self::$productionBase * ($this->productionMultiplier ** ($this->stone_quarry_level - 1));
    }

    public function ironPerHour(): float
    {
        return self::$productionBase * ($this->productionMultiplier ** ($this->iron_mine_level - 1));
    }


}
