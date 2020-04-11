@php
$types = ['alert', 'success', 'warning', 'error', 'info'];
@endphp

@foreach ($types as $t)

    @if (session($t))
        <div class="notification"
             data-notification-message="{{ session($t) }}"
             data-notification-type="{{ $t }}"
        ></div>
    @endif

@endforeach
{{--
<div class="notification"
     data-notification-message="This is a test message"
     data-notification-type="success"
></div> --}}