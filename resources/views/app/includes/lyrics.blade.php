<section class="lyrics">

    <div class="lyrics__inner">

        <header class="lyrics__header">

            <div class="lyrics__header-left">

                <a class="lyrics__header-artist" href="#">{{ $song->artist }}</a>

                <h1 class="lyrics__header-title">{{ $song->title }}</h1>

                <span class="lyrics__header-tags">#12 #13 #234</span>

            </div>

            <div class="lyrics__header-right">
                <button class="btn btn--small">Edit</button>
            </div>

        </header>

        <main class="lyrics__main">

            @if ($song->lyrics)
                {!! $song->lyrics !!}
            @else
                <a href="#">Add some lyrics..</a>
            @endif

        </main>

    </div>

</section>