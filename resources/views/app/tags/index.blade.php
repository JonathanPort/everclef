@extends('app.base')

@section('content')

    <header class="view-header">

        <div class="view-header__inner">

            <h1 class="view-header__heading">Tags</h1>

        </div>

    </header>


    @if ($tags->count())
    <div class="table">

        <table class="table__elem">

            <thead class="table__head">

                <tr>
                    <th>Name</th>
                    <th>Songs</th>
                    <th></th>
                </tr>

            </thead>

            <tbody class="table__body">

                @foreach ($tags as $tag)

                    <tr class="table__row">

                        <td class="table__column">
                            <a href="{{ QueryString::routeWithParams('repertoire', 'tag', $tag->name) }}"">{{ $tag->name }}</a>
                        </td>

                        <td class="table__column">
                            {{ $tag->songs->count() }}
                        </td>

                        <td class="table__column" align="right">
                            <img class="table__action-icon"
                                 src="{{ asset('images/icons/more-grey.png') }}"
                                 data-toggle-action-menu="tag-{{ $tag->id }}"
                            >
                            @include('app.includes.action-menu', [
                                'id' => 'tag-' . $tag->id,
                                'actions' => [
                                    ['label' => 'Edit', 'href' => route('tag.edit', ['tag' => $tag->id])],
                                    ['label' => 'Delete', 'href' => '#'],
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
        <small>Nothing here just yet..</small>
    </div>

    @endif

@endsection