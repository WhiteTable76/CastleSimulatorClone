<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VillageController extends Controller
{

    public function Village(){

        $resources = auth()->user()->resources;
        $villages = auth()->user()->villages;

        return view('wioska', ['resources' => $resources, 'villages' => $villages]);
    }

    public function upgradeLoggingSite()
    {
        $resources = auth()->user()->resources;
        $villages = auth()->user()->villages;

        $cost = $villages->KosztUlepszenia();

        if ($resources->wood < $cost['wood']){
            return back()->with('error', 'za mało drewna!');
        }

        DB::transaction(function() use ($resources, $villages, $cost){
            $resources->decrement('wood', $cost['wood']);
            $villages->increment('logging_site_level');



        });

        return back()->with('succes', 'Chata drwali ulepszona!');

    }


}
