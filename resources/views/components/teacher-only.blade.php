@if($isTeacher())
    {{ $slot }}
@elseif($fallback)
    {{ $fallback }}
@endif

