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

        return view('wioska', ['resources' => $resources, 'village' => $village]);
    }

    public function upgradeLoggingSite()
    {
        $resources = auth()->user()->resources;
        $village = auth()->user()->village;

        $cost = $village->KosztUlepszenia();

        if ($resources->wood < $cost['wood']){
            return back()->with('error', 'za mało drewna!');
        }

        DB::transaction(function() use ($resources, $village, $cost){
            $resources->decrement('wood', $cost['wood']);
            $village->increment('logging_site_level');



        });

        return back()->with('succes', 'Chata drwali ulepszona!');

    }





}
