<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlayerController extends Controller
{
        public function Player(){

        $user = auth()->user();

        return view('gracz',[
            'user'=> $user,
            'level'=> $user->level(),
            'xpProgress'=> $user->xpProgressToNextLevel(),
        ]);
    }
}
