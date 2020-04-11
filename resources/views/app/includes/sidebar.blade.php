<div class="app-sidebar">

    @php

    $setLists = \Auth::user()->setLists()->get();
    $setListsSub = [];

    foreach ($setLists as $l) {
        $setListsSub[] = [
            'label' => $l->name,
            'href' => route('set-lists.show', ['setList' => $l->id])
        ];
    };

    $nav = [
        [
            'primary' => [
                'icon' => asset('images/icons/repertoire.png'),
                'label' => 'Repertoire',
                'href' => route('repertoire')
            ],
            'sub' => [
                [
                    'label' => 'Originals',
                    'href' => route('repertoire') . '?type=original'
                ],
                [
                    'label' => 'Covers',
                    'href' => route('repertoire') . '?type=cover'
                ],
                [
                    'label' => 'Set lists',
                    'href' => route('set-lists')
                ],
            ],
            'action' => [
                'label' => 'Add song..',
                'href' => '#'
            ]
        ],
        [
            'primary' => [
                'icon' => asset('images/icons/photos-folder.png'),
                'label' => 'Originals',
                'href' => '#'
            ],
            'sub' => [
                [
                    'label' => 'Book 1',
                    'href' => '#'
                ],
                [
                    'label' => 'Book 2',
                    'href' => '#'
                ],
            ],
            'action' => [
                'label' => 'Write..',
                'href' => '#'
            ]
        ],
        [
            'primary' => [
                'icon' => asset('images/icons/photos-folder.png'),
                'label' => 'Covers',
                'href' => route('covers')
            ],
            'action' => [
                'label' => 'Add cover..',
                'href' => route('cover.create')
            ]
        ],
        // [
        //     'primary' => [
        //         'icon' => asset('images/icons/set-list.png'),
        //         'label' => 'Set lists',
        //         'href' => route('set-lists')
        //     ],
        //     'sub' => $setListsSub,
        //     'action' => [
        //         'label' => 'New set list',
        //         'href' => '#',
        //         'attr' => [
        //             'data-toggle-set-list-maker' => SetList::buildSetListMakerDataForJS()
        //         ]
        //     ]
        // ],
        [
            'primary' => [
                'icon' => asset('images/icons/hashtag-black.png'),
                'label' => 'Tags',
                'href' => route('tags')
            ],
        ],
    ];
    @endphp



    @foreach ($nav as $n)

        <nav class="app-sidebar__nav">

            <a class="app-sidebar__nav-primary" href="{{ $n['primary']['href'] }}">

                <span class="app-sidebar__nav-primary-label">
                    <img src="{{ $n['primary']['icon'] }}">
                    {{ $n['primary']['label'] }}
                </span>

                @if (isset($n['sub']) || isset($n['action']))
                <ul class="app-sidebar__nav-sub">

                    @isset ($n['sub'])

                        @foreach ($n['sub'] as $s)

                            <li>
                                <a href="{{ $s['href'] }}"
                                   @isset ($s['attr'])
                                    @foreach ($s['attr'] as $key => $attr)
                                    {{ $key }}="{{ $attr }}"
                                    @endforeach
                                   @endisset
                                >
                                    {{ $s['label'] }}
                                </a>
                            </li>

                        @endforeach

                    @endisset

                    @isset($n['action'])
                    <li>
                        <a href="{{ $n['action']['href'] }}"
                           class="blue"
                           @isset ($n['action']['attr'])
                            @foreach ($n['action']['attr'] as $key => $attr)
                            {{ $key }}="{{ $attr }}"
                            @endforeach
                            @endisset
                        >
                            {{ $n['action']['label'] }}
                        </a>
                    </li>
                    @endisset

                </ul>
                @endif

            </a>
        </nav>

    @endforeach

</div>