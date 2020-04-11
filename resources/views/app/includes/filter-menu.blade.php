<div class="filter-menu"
     data-filter-menu="{{ $key }}"
     data-filter-menu-url="{{ url()->current() }}"
     data-filter-menu-params="{{ json_encode(\Request::query()) }}"
>

    <div class="filter-menu__bg" data-toggle-filter-menu="{{ $key }}"></div>

    <div class="filter-menu__main">

        <div class="filter-menu__header">

            <div class="filter-menu__search search-input">
                <img src="{{ asset('images/icons/search.png') }}">
                <input type="text" placeholder="Search for {{ $key }}s">
            </div>

            <span class="filter-menu__uncheck">Uncheck all</span>

        </div>

        <div class="filter-menu__body">

            @foreach ($data as $d)

                <label class="filter-menu__row">

                    <span class="filter-menu__row-text">{{ $d }}</span>
                    @php
                    $params = QueryString::paramToArray(\Request::query($key));
                    @endphp
                    <input type="checkbox"
                           value="{{ $d }}"
                           data-filter-menu-checkbox
                           @if (in_array($d, $params))
                           checked
                           @endif
                    >

                    <div class="checkbox">
                        <img src="{{ asset('images/icons/blue-check.png') }}">
                    </div>

                </label>

            @endforeach

        </div>

        <div class="filter-menu__footer">

            <button class="filter-menu__apply btn btn--small">Apply</button>

        </div>

    </div>

</div>