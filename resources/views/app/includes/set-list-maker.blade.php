@php
if (! isset($data)) $data = json_encode([]);
@endphp

<div class="set-list-maker">

    <div class="set-list-maker__bg" data-toggle-set-list-maker></div>

    <form class="set-list-maker__inner" method="POST">

        @csrf

        <div class="set-list-maker__header">

            <div class="set-list-maker__search search-input search-input--large" data-lyrics-search>

                <div class="search-input__results-bg"></div>

                <div class="search-input__loader"></div>
                <img src="{{ asset('images/icons/search.png') }}">
                <input type="text" placeholder="Search library">

                <div class="search-input__results"></div>

            </div>

        </div>

        <div class="set-list-maker__main"></div>

        <div class="set-list-maker__footer">

            <input class="set-list-maker__name-input" type="text" name="name" required placeholder="Setlist name..">

            <div class="set-list-maker__buttons">

                <button class="btn btn--small btn--grey"
                        type="button"
                        data-toggle-set-list-maker>Cancel</button>

                <button class="btn btn--small"
                        type="submit">Save</button>

            </div>

        </div>

    </form>

</div>