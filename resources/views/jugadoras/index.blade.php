@extends('layouts.equip')
@section('title', __('Llistat de Jugadores'))

@section('content')
<div class="container">
    <h1 class="title">{{ __('Guia de Jugadores') }}</h1>
    <p class="mb-4">
        <a href="{{ route('jugadoras.create') }}" class="btn btn--primary">{{ __('Afegir Jugadora') }}</a>
    </p>

    <div class="grid-cards">
        @foreach ($jugadoras as $jugadora)
            <article class="card">
                <header class="card__header">
                    <h2 class="card__title">{{ $jugadora->nom }}</h2>
                    <span class="card__badge">{{ __('Dorsal') }}: {{ $jugadora->dorsal }}</span>
                </header>

                <div class="card__body">
                    <p><strong>{{ __('Equip') }}:</strong> {{ $jugadora->equip->nom }}</p>
                    <p><strong>{{ __('Edat') }}:</strong> {{ \Carbon\Carbon::parse($jugadora->data_naixement)->age }} {{ __('anys') }}</p>
                </div>

                <footer class="card__footer">
                    <a class="btn btn--ghost" href="{{ route('jugadoras.show', $jugadora) }}">{{ __('Fitxa') }}</a>
                    
                    <form method="POST" action="{{ route('jugadoras.destroy', $jugadora) }}" class="inline"
                          onsubmit="return confirm('{{ __('Segur que vols eliminar aquesta jugadora?') }}');">
                        @csrf @method('DELETE')
                        <button class="btn btn--danger" type="submit">{{ __('Eliminar') }}</button>
                    </form>
                </footer>
            </article>
        @endforeach
    </div>
</div>
@endsection