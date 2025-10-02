@props([
    'title' => '',
    'subtitle' => null,
    'icon' => null,
    'class' => '',
    'actions' => null
])

<div class="hero glass-effect p-4 mb-4 animate__animated animate__fadeInUp {{ $class }}"
     style="background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h3 class="mb-2 gradient-text fw-bold">
                @if($icon)
                    <i class="{{ $icon }} me-2"></i>
                @endif
                {{ $title }}
            </h3>
            @if($subtitle)
                <p class="text-muted mb-0">{{ $subtitle }}</p>
            @endif
        </div>
        
        @if($actions)
            <div class="d-flex gap-2">
                {{ $actions }}
            </div>
        @endif
    </div>
</div>

