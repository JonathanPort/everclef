@extends('app.base')

@section('content')

    <header class="view-header">

        <div class="view-header__inner">

            <h1 class="view-header__heading">{{ $setList->name }}</h1>

            <button class="btn"
                    data-toggle-set-list-maker='{{ SetList::buildSetListMakerDataForJS($setList->songs) }}'
            >Edit</button>

        </div>

    </header>

    @php
    $songs = [];
    foreach ($setList->songs()->get() as $setListSong) {
        $songs[] = $setListSong->song()->first();
    }
    @endphp

    @include('app.includes.lyrics-coverflow', ['songs' => $songs])

@endsection