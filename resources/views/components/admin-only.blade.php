@if($isAdmin())
    {{ $slot }}
@elseif($fallback)
    {{ $fallback }}
@endif

