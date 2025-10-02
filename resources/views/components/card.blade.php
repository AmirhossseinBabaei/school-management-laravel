@props([
    'title' => null,
    'subtitle' => null,
    'type' => 'default',
    'class' => '',
    'headerClass' => '',
    'bodyClass' => '',
    'footerClass' => ''
])

@php
    $cardClasses = match($type) {
        'primary' => 'card-primary',
        'success' => 'card-success',
        'warning' => 'card-warning',
        'danger' => 'card-danger',
        'info' => 'card-info',
        'glass' => 'glass-effect border-0 shadow-lg',
        default => ''
    };
    
    $headerClasses = match($type) {
        'primary' => 'bg-primary text-white',
        'success' => 'bg-success text-white',
        'warning' => 'bg-warning text-dark',
        'danger' => 'bg-danger text-white',
        'info' => 'bg-info text-white',
        'glass' => 'glass-effect border-0',
        default => ''
    };
@endphp

<div class="card {{ $cardClasses }} {{ $class }}">
    @if($title || $subtitle || $header)
        <div class="card-header {{ $headerClasses }} {{ $headerClass }}">
            @if($title)
                <h5 class="mb-0 {{ $type === 'glass' ? 'gradient-text fw-bold' : '' }}">
                    @if($icon)
                        <i class="{{ $icon }} me-2"></i>
                    @endif
                    {{ $title }}
                </h5>
            @endif
            
            @if($subtitle)
                <p class="mb-0 {{ $type === 'glass' ? 'text-muted' : '' }}">{{ $subtitle }}</p>
            @endif
            
            {{ $header }}
        </div>
    @endif

    <div class="card-body {{ $bodyClass }}">
        {{ $slot }}
    </div>

    @if($footer)
        <div class="card-footer {{ $footerClass }}">
            {{ $footer }}
        </div>
    @endif
</div>

