@props(['village', 'buildingType', 'label'])

<div style="border: 1px solid black; padding: 10px;">
    <p>{{ $label }} — poziom {{ $village->{$buildingType . '_level'} }}</p>

    @if ($village->czyUlepszaSie($buildingType))
        <p>Ulepszanie w toku: <span id="timer-{{ $buildingType }}"></span></p>
        <script>
            (function() {
                const endsAt = new Date("{{ $village->kiedyKoniecUlepszania($buildingType)->toIso8601String() }}").getTime();
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
    <p>Koszt:
    @foreach ($cost as $resource => $amount)
        {{ $amount }} {{ $resource }}{{ !$loop->last ? ', ' : '' }}
    @endforeach
    </p>

        <form action="{{ route('village.upgradeBuilding', $buildingType) }}" method="POST">
            @csrf
            <button>Ulepsz</button>
        </form>
    @endif
</div>
