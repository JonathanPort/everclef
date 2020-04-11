@extends('app.base')

@section('content')

    @php
    $arr = [];
    $ids = [];
    foreach ($repertoire as $r) {
        $arr[] = $r->song;
        $ids[] = $r->song->id;
    }

    $songs = collect($arr);
    @endphp

    <header class="view-header">

        <div class="view-header__inner">

            <h1 class="view-header__heading">Repertoire</h1>

            @include('app.includes.filters', [
                'filters' => [
                    'artist' => [
                        'label' => 'Artist',
                        'key' => 'artist',
                        'data' => \Auth::user()->artists()
                    ],
                    'tag' => [
                        'label' => 'Tag',
                        'key' => 'tag',
                        'data' => \Auth::user()->tagList()
                    ]
                ]
            ])

            @if (\Request::query())
                <button class="view-header__btn btn"
                        data-toggle-set-list-maker='{{ SetList::buildSetListMakerDataForJS($repertoire) }}'>
                    Make setlist
                </button>

            @endif

        </div>

    </header>


    @if ($repertoire->count())

        @include('app.includes.lyrics-coverflow', ['songs' => $songs])

    @else

    <div class="table__no-results">
        <small>Nothing here just yet..</small> <br> Click "Add song" to get started
    </div>

    @endif

@endsection