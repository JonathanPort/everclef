<div class="action-menu {{ isset($position) ? 'action-menu--' . $position : '' }}" data-action-menu="{{ $id }}">

    <div class="action-menu__bg" data-toggle-action-menu="{{ $id }}"></div>

    <div class="action-menu__main">
        @foreach ($actions as $a)

            <a class="action-menu__row"
               href="{{ $a['href'] }}"
               @isset ($a['attr'])
               @foreach ($a['attr'] as $key => $attr)
               {{ $key }}="{{ $attr }}"
               @endforeach
               @endisset
            >
                {{ $a['label'] }}
            </a>

        @endforeach
    </div>

</div>