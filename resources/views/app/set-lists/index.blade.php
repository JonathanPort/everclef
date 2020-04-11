@extends('app.base')

@section('content')

    <header class="view-header">

        <div class="view-header__inner">

            <h1 class="view-header__heading">Set lists</h1>

            <button class="btn"
                    type="button"
                    data-toggle-set-list-maker="{{ SetList::buildSetListMakerDataForJS() }}"
            >New setlist</button>

        </div>

    </header>


    @if ($setLists->count())
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

                @foreach ($setLists as $list)

                    <tr class="table__row">

                        <td class="table__column">
                            <a href="{{ route('set-lists.show', ['setList' => $list->id]) }}">{{ $list->name }}</a>
                        </td>

                        <td class="table__column">
                            {{ $list->songs()->count() }}
                        </td>

                        <td class="table__column" align="right">
                            <img class="table__action-icon"
                                 src="{{ asset('images/icons/more-grey.png') }}"
                                 data-toggle-action-menu="set-list-{{ $list->id }}"
                            >
                            @include('app.includes.action-menu', [
                                'id' => 'set-list-' . $list->id,
                                'actions' => [
                                    [
                                        'label' => 'Edit',
                                        'href' => '#',
                                        'attr' => [
                                            'data-toggle-set-list-maker' => SetList::buildSetListMakerDataForJS($list->songs)
                                        ]
                                    ],
                                    [
                                        'label' => 'Delete',
                                        'href' => route('set-list.delete', ['setList' => $list->id]),
                                        'attr' => [
                                            'data-display-confirm' => trans('messages.set-list-delete-confirm')
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
        <small>Nothing here just yet..</small>
    </div>

    @endif

@endsection