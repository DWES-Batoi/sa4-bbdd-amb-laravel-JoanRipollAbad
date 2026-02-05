@extends('layouts.equip')

@section('content')
<div class="container">
    <h1 class="title">{{ __("Guia d'Equips") }}</h1>

    <div class="grid-cards">
        @foreach ($equips as $equip)
            <article class="card">
                <header class="card__header">
                    <h2 class="card__title">{{ $equip->nom }}</h2>
                    {{-- Usamos 'Titols' sin acento porque así está en la clave de tu JSON --}}
                    <span class="card__badge">{{ __('Titols') }}: {{ $equip->titols }}</span>
                </header>

                <div class="card__body">
                    <p><strong>{{ __('Estadi') }}:</strong> {{ $equip->estadi->nom ?? '—' }}</p>
                    <p><strong>{{ __('Jugadores') }}:</strong> {{ $equip->jugadoras->count() }}</p>
                    <p><strong>{{ __('Edat Mitjana') }}:</strong> {{ $equip->edadMedia() }} {{ __('anys') }}</p>
                </div>

                <footer class="card__footer">
                    <a class="btn btn--ghost" href="{{ route('equips.show', $equip) }}">{{ __('Veure') }}</a>
                    <a class="btn btn--primary" href="{{ route('equips.edit', $equip) }}">{{ __('Editar') }}</a>

                    <form method="POST" action="{{ route('equips.destroy', $equip) }}" class="inline" 
                          onsubmit="return confirm('{{ __('Segur que vols eliminar aquest equip?') }}');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn--danger" type="submit">{{ __('Eliminar') }}</button>
                    </form>
                </footer>
            </article>
        @endforeach
    </div>
</div>
@endsection