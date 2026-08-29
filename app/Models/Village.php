<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $fillable = ['user_id', 'logging_site_level', 'stone_quarry_level','iron_mine_level'];

    protected static array $BazowyKoszt = [
        'logging_site' => ['wood' => 50],
        'stone_quarry' => ['wood' => 50],
        'iron_mine' => ['wood' => 50]
    ];

    protected static array $CzasBazowy =[
        'logging_site'=> 30,
        'stone_quarry'=> 30,
        'iron_mine'=> 30,
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
        $base = self::$BazowyKoszt[$buildingType] ?? ['wood' => 0];
        $level = $this->{$buildingType . '_level'};
        $factor = $this->multiplier ** ($level - 1);

        return [
            'wood' => (int) round($base['wood'] * $factor),
        ];
    }

    public function czasUlepszenia(string $buildingType): int
    {
        $base = self::$CzasBazowy[$buildingType] ?? 30;
        $level = $this->{$buildingType . '_level'};
        $factor = $this->durationMultiplier ** ($level - 1);

        return (int) round($base * $factor);
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
