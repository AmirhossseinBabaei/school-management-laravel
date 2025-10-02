@props([
    'type' => 'info',
    'title' => null,
    'dismissible' => true,
    'class' => '',
    'icon' => null
])

@php
    $baseClasses = 'alert alert-dismissible fade show';
    
    $typeClasses = match($type) {
        'primary' => 'alert-primary',
        'secondary' => 'alert-secondary',
        'success' => 'alert-success',
        'danger' => 'alert-danger',
        'warning' => 'alert-warning',
        'info' => 'alert-info',
        'light' => 'alert-light',
        'dark' => 'alert-dark',
        default => 'alert-info'
    };
    
    $defaultIcons = match($type) {
        'success' => 'fa-solid fa-check-circle',
        'danger' => 'fa-solid fa-exclamation-triangle',
        'warning' => 'fa-solid fa-exclamation-circle',
        'info' => 'fa-solid fa-info-circle',
        'primary' => 'fa-solid fa-info-circle',
        default => 'fa-solid fa-info-circle'
    };
    
    $iconToUse = $icon ?? $defaultIcons;
    $allClasses = trim($baseClasses . ' ' . $typeClasses . ' ' . $class);
@endphp

<div class="{{ $allClasses }}" role="alert">
    @if($iconToUse)
        <i class="{{ $iconToUse }} me-2"></i>
    @endif
    
    @if($title)
        <h6 class="alert-heading mb-2">{{ $title }}</h6>
    @endif
    
    {{ $slot }}
    
    @if($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>

