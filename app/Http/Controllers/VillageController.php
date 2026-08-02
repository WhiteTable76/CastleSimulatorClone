<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VillageController extends Controller
{

    public function Village(){

        $resources = auth()->user()->resources;
        $villages = auth()->user()->villages;

        return view('wioska', ['resources' => $resources], ['villages' => $villages]);
    }



}
