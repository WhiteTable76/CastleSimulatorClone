@extends('layouts.app')

@section('title', 'Wioska')

@section('content')

<h1>Główna Wioska</h1>

<div style="border-bottom: 2px solid black; padding: 10px; display: flex; gap: 20px;">
    <span>Drewno: {{ $resources->wood }}</span>
</div>

<br>
 <div style="border: 3px solid black;">

    <div>
        <a>Chata drwala</a>
        <br>
        <a>Poziom: {{ $villages->logging_site_level }}</a>
        <br>
        <button>Ulepsz</button>
    </div>

 </div>


@endsection
