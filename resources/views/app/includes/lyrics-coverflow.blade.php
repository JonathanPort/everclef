<div class="lyrics-coverflow">

    <div class="lyrics-coverflow__header">

        <div class="lyrics-coverflow__tags"></div>

        <div class="lyrics-coverflow__pagination swiper-pagination"></div>

    </div>

    <div class="lyrics-coverflow__swiper">

        <div class="swiper-wrapper">

            @foreach ($songs as $song)

                @php
                $tags = $song->tagList();
                $arr = [];

                foreach ($tags as $tag) {
                    $arr[] = [
                        'tag' => $tag,
                        'href' => QueryString::routeWithParams('repertoire', 'tag', $tag)
                    ];
                }

                $tags = $arr;
                @endphp

                <div class="swiper-slide"
                     data-tags="{{ json_encode($tags) }}">

                    <div class="lyrics-coverflow__sheet panel">

                        <div class="panel__header">

                            <div class="lyrics-coverflow__sheet-title">
                                <span>{{ $song->title }}</span> -
                                <a href="#">{{ $song->artist }}</a>
                            </div>

                            <div class="lyrics-coverflow__sheet-actions">

                                <a class="btn btn--xsmall" href="{{ $song->link() }}">View</a>

                                <img class="lyrics-coverflow__sheet-action-icon"
                                     src="{{ asset('images/icons/more-grey.png') }}"
                                     data-toggle-action-menu="song-{{ $song->id }}"
                                >

                                @include('app.includes.action-menu', [
                                    'id' => 'song-' . $song->id,
                                    'actions' => [
                                        ['label' => 'Edit', 'href' => route('cover.edit', ['cover' => $song->id])],
                                        [
                                            'label' => 'Delete',
                                            'href' => route('cover.delete', ['cover' => $song->id]),
                                            'attr' => [
                                                'data-display-confirm' => 'Are you sure you want to delete this cover?'
                                            ]
                                        ],
                                    ],
                                    'position' => 'right'
                                ])

                            </div>

                        </div>

                        <div class="panel__body">

                            <div class="lyrics-coverflow__sheet-body lyrics__main">
                                {!! $song->lyrics !!}
                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

    <div class="lyrics-coverflow__nav">
        <div class="swiper-button-prev">
            <img src="{{ asset('images/icons/arrow-rounded-grey.png') }}">
        </div>
        <div class="swiper-button-next">
            <img src="{{ asset('images/icons/arrow-rounded-grey.png') }}">
        </div>
    </div>

</div>