@extends('app.base')

@section('content')

    <header class="view-header">

        <div class="view-header__inner">

            <h1 class="view-header__heading">Covers</h1>

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

            <a class="view-header__btn btn" href="{{ route('cover.create') }}">
                <img src="{{ asset('images/icons/add-rounded-white.png') }}">
                Add song
            </a>

        </div>

    </header>


    @if ($covers->count())
    <div class="table">

        <table class="table__elem">

            <thead class="table__head">

                <tr>
                    <th>
                        <a href="{{ QueryString::routeWithOrderParams('covers', 'title') }}">
                            Title
                        </a>
                    </th>
                    <th>
                        <a href="{{ QueryString::routeWithOrderParams('covers', 'artist') }}">
                            Artist
                        </a>
                    </th>
                    <th>Tags</th>
                    <th></th>
                </tr>

            </thead>

            <tbody class="table__body">

                @foreach ($covers as $row)

                    <tr class="table__row">

                        <td class="table__column">
                            <a href="{{ route('cover.show', ['cover' => $row->id]) }}">{{ $row->title }}</a>
                        </td>

                        <td class="table__column">
                            <a href="{{ QueryString::routeWithParams('covers', 'artist', $row->artist) }}">
                                {{ $row->artist }}
                            </a>
                        </td>

                        <td class="table__column">

                            @php
                            $tags = $row->tags()->limit(3)->get();
                            @endphp

                            @foreach ($tags as $t)
                            <a class="tag" href="{{ QueryString::routeWithParams('covers', 'tag', $t->name) }}">
                                #{{ $t->name }}
                            </a>
                            @endforeach

                        </td>

                        <td class="table__column" align="right">
                            <img class="table__action-icon"
                                 src="{{ asset('images/icons/more-grey.png') }}"
                                 data-toggle-action-menu="song-{{ $row->id }}"
                            >
                            @include('app.includes.action-menu', [
                                'id' => 'song-' . $row->id,
                                'actions' => [
                                    ['label' => 'Edit', 'href' => route('cover.edit', ['cover' => $row->id])],
                                    [
                                        'label' => 'Delete',
                                        'href' => route('cover.delete', ['cover' => $row->id]),
                                        'attr' => [
                                            'data-display-confirm' => 'Are you sure you want to delete this cover?'
                                        ]
                                    ],
                                ],
                                'position' => 'right'
                            ])
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    @else

    <div class="table__no-results">
        <small>Nothing here just yet..</small> <br> Click "Add song" to get started
    </div>

    @endif

@endsection