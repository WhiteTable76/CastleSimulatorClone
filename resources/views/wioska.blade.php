@extends('layouts.app')

@section('title', 'Wioska')

@section('content')

<h1>Główna Wioska</h1>

<div style="border-bottom: 2px solid black; padding: 10px; display: flex; gap: 20px;">
    <span>Drewno: {{ $resources->wood }}</span>
    <span>Kamień: {{ $resources->stone }}</span>
    <span>Żelazo: {{ $resources->iron }}</span>
</div>

<br>

<x-building-card :village="$village" building-type="town_hall" label="Ratusz" />
<x-building-card :village="$village" building-type="logging_site" label="Tartak" />
<x-building-card :village="$village" building-type="stone_quarry" label="Kamieniołom" />
<x-building-card :village="$village" building-type="iron_mine" label="Kopalnia żelaza" />

@if (session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif

@if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

@endsection
