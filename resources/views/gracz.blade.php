@extends('layouts.app')

@section('title', 'Wioska')

@section('content')

<h1>Profil Gracza: {{ auth()->user()->player_name }}</h1>

<div style="border: 3px solid black;">
    <p>Poziom: {{auth()->user()->level()  }} </p>
    <a>Całkowite Doświadczenie: {{ auth()->user()->experience }} ||</a>
    <a>Brakujące doświadczenie: {{ $xpProgress['needed'] }} </a>
</div>

@endsection
