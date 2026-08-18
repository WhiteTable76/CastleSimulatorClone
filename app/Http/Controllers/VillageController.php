<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VillageController extends Controller
{

    public function Village(){

        $resources = auth()->user()->resources;
        $resources->collectPendingResources();

        $village = auth()->user()->village;
        $village->finalizujZakonczoneUlepszenia();

        return view('wioska', ['resources' => $resources, 'village' => $village]);
    }

   public function upgradeBuilding(string $buildingType)
    {
        $resources = auth()->user()->resources;
        $village = auth()->user()->village;

        $village->finalizujZakonczoneUlepszenia();

        if ($village->czyUlepszaSie($buildingType)) {
            return back()->with('error', 'Ten budynek jest już ulepszany!');
        }

        if (!$village->czyMozeZaczacUlepszanie()) {
            return back()->with('error', 'Możesz ulepszać tylko jeden budynek naraz!');
        }

        $cost = $village->kosztUlepszenia($buildingType);

        if ($resources->wood < $cost['wood']) {
            return back()->with('error', 'Za mało drewna!');
        }

        DB::transaction(function() use ($resources, $village, $cost, $buildingType) {
            $resources->decrement('wood', $cost['wood']);
            $village->rozpocznijUlepszanie($buildingType);
        });

        auth()->user()->addExperience(50);

        return back()->with('success', 'Ulepszanie rozpoczęte!');



    }

}
