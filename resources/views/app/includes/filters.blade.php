<div class="filters">

    <div class="filters__inner">

        <div class="filters__block filters__block--no-click">
            <div class="filters__block-inner">
                <img class="filters__icon" src="{{ asset('images/icons/filter.png') }}">
                <span class="filters__text">Filter by</span>
            </div>
        </div>

        @php
        $displayReset = false;
        @endphp

        @foreach ($filters as $f)

            <div class="filters__block">

                <div class="filters__block-inner"
                     data-toggle-filter-menu="{{ $f['key'] }}">

                     <span class="filters__text">{{ $f['label'] }}</span>

                    @php
                    $count = 0;
                    $params = QueryString::paramToArray(\Request::query($f['key']));

                    foreach ($f['data'] as $d) {
                        if (in_array($d, $params)) {
                            $displayReset = true;
                            $count++;
                        }
                    }
                    @endphp
                    @if ($count)
                        <span class="filters__count">{{ $count }}</span>
                    @endif
                    <img class="filters__chevron" src="{{ asset('images/icons/chevron-down.png') }}">

                </div>

                @include('app.includes.filter-menu', [
                    'data' => $f['data'],
                    'key' => $f['key']
                ])

            </div>

        @endforeach

        @if ($displayReset)
        <a class="filters__block filters__block--reset" href="{{ url()->current() }}">
            <div class="filters__block-inner">
                <img class="filters__icon" src="{{ asset('images/icons/reset.png') }}">
                <span class="filters__text">Reset filters</span>
            </div>
        </a>
        @endif

    </div>

</div>