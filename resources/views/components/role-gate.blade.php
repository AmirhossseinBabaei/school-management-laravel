@if($hasAccess())
    {{ $slot }}
@elseif($fallback)
    {{ $fallback }}
@endif

