<x-filament-panels::page>
    @if ($this->hasInfolist())
        {{ $this->infolist }}
    @else
        {{ $this->form }}
    @endif

    @if (count($relationManagers = $this->getRelationManagers()))
        <x-filament-panels::resources.relation-managers
            :active-manager="$activeRelationManager"
            :managers="$relationManagers"
            :owner-record="$record"
            :page-class="static::class"
        />
    @endif
    {{-- <p>Fájl megtekintése: <a href="{{ '/storage/'. $record->attachment }}" target="_blank">{{ $record->nev }}</a></p> --}}
    {!! QrCode::size(300)->backgroundColor(255,90,0)->generate(env('APP_URL') . '/storage/'. $record->attachment) !!}
</x-filament-panels::page>
