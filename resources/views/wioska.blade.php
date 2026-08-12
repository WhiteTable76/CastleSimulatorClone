@extends('layouts.app')

@section('title', 'Wioska')

@section('content')

<h1>Główna Wioska</h1>

<div style="border-bottom: 2px solid black; padding: 10px; display: flex; gap: 20px;">
    <span>Drewno: {{ $resources->wood }}</span>
</div>

<br>

@php $buildingType = 'logging_site'; @endphp

    <div style="border: 1px solid black; padding: 10px;">
        <p>Tartak — poziom {{ $village->logging_site_level }}</p>

        @if ($village->czyUlepszaSie($buildingType))
            <p>Ulepszanie w toku: <span id="timer-{{ $buildingType }}"></span></p>
            <script>
                (function() {
                    const endsAt = new Date("{{ $village->kiedyKoniecUlepszania($buildingType) }}").getTime();
                    const timerEl = document.getElementById('timer-{{ $buildingType }}');

                    function updateTimer() {
                        const now = new Date().getTime();
                        const remaining = Math.max(0, Math.floor((endsAt - now) / 1000));
                        const minutes = Math.floor(remaining / 60);
                        const seconds = remaining % 60;
                        timerEl.textContent = minutes + "m " + seconds + "s";

                        if (remaining <= 0) {
                            clearInterval(interval);
                            location.reload();
                        }
                    }

                    updateTimer();
                    const interval = setInterval(updateTimer, 1000);
                })();
            </script>
        @elseif (!$village->czyMozeZaczacUlepszanie())
            <p style="color: gray;">Trwa ulepszanie innego budynku.</p>
        @else
            @php $cost = $village->kosztUlepszenia($buildingType); @endphp
            <p>Koszt: {{ $cost['wood'] }} drewna, czas: {{ $village->czasUlepszenia($buildingType) }}s</p>

            <form action="{{ route('village.upgradeBuilding', $buildingType) }}" method="POST">
                @csrf
                <button>Ulepsz</button>
            </form>
        @endif
    </div>

    @if (session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif



@endsection
