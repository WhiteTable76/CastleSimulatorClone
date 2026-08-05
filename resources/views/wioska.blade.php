@extends('layouts.app')

@section('title', 'Wioska')

@section('content')

<h1>Główna Wioska</h1>

<div style="border-bottom: 2px solid black; padding: 10px; display: flex; gap: 20px;">
    <span>Drewno: {{ $resources->wood }}</span>
</div>

<br>

@php $cost = $villages->KosztUlepszenia(); @endphp


 <div style="border: 1px solid black; padding: 10px;;">
        <p>Chata drwali - poziom: {{ $villages->logging_site_level }}</p>
        <p>Koszt Ulepszenia: {{ $cost['wood'] }} drewna</p>

        <form action="{{ route('village.upgradeLoggingSite') }}" method="POST">
            @csrf
            <button>Ulepsz</button>
        </form>
 </div>


@endsection
