@extends('app.base')

@section('content')

    <header class="view-header">

        <div class="view-header__inner">

            <h1 class="view-header__heading">
                @isset ($cover)
                {{ $cover->title }}
                @else
                Add a cover
                @endisset
            </h1>

            <div class="view-header__search search-input search-input--dark search-input--large" data-lyrics-search>

                <div class="search-input__results-bg"></div>

                <div class="search-input__loader"></div>
                <img src="{{ asset('images/icons/search.png') }}">
                <input type="text" placeholder="Search for a song..">

                <div class="search-input__results"></div>

            </div>

        </div>

    </header>


    <form class="columns"
          @isset($cover)
          action="{{ route('cover.edit.submit', ['cover' => $cover->id]) }}"
          @else
          action="{{ route('cover.create.submit') }}"
          @endisset
          method="POST"
          data-quill-form>

        @csrf

        <div class="column is-three-quarters">

            @include('app.includes.lyrics-editor')

        </div>

        <div class="column">

            <div class="panel">

                <div class="panel__body">

                    <div class="input">
                        <input type="text"
                               name="title"
                               placeholder="Song title"
                               @isset ($cover)
                               @if (old('title'))
                               value="{{ old('title') }}"
                               @else
                               value="{{ $cover->title }}"
                               @endif
                               @endisset
                               required>
                    </div>

                    <div class="input">
                        <input type="text"
                               name="artist"
                               placeholder="Artist"
                               @isset ($cover)
                               @if (old('artist'))
                               value="{{ old('artist') }}"
                               @else
                               value="{{ $cover->artist }}"
                               @endif
                               @endisset
                               required>
                    </div>

                    <div class="input">
                        <input type="text"
                               name="album"
                               placeholder="Album"
                               @isset ($cover)
                               @if (old('album'))
                               value="{{ old('album') }}"
                               @else
                               value="{{ $cover->album }}"
                               @endif
                               @endisset
                               >
                    </div>

                    <div class="input">
                        <input type="text"
                               name="tags"
                               placeholder="#tags"
                               data-tag-input="{{ json_encode(\Auth::user()->tagList()) }}"
                               @isset ($cover)
                               @if (old('tags'))
                               value="{{ old('tags') }}"
                               @else
                               data-tag-input-existing="{{ json_encode($cover->tagList()) }}"
                               @endif
                               @endisset
                               >
                    </div>

                    <button class="btn btn--med" type="submit">
                        @isset ($cover)
                        Save
                        @else
                        Add to repertoire
                        @endisset
                    </button>

                </div>

            </div>

        </div>

    </form>

@endsection