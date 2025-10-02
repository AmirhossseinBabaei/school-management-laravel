@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'class' => '',
    'disabled' => false,
    'loading' => false,
    'icon' => null,
    'iconPosition' => 'left'
])

@php
    $baseClasses = 'btn';
    
    $variantClasses = match($variant) {
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'success' => 'btn-success',
        'danger' => 'btn-danger',
        'warning' => 'btn-warning',
        'info' => 'btn-info',
        'light' => 'btn-light',
        'dark' => 'btn-dark',
        'outline-primary' => 'btn-outline-primary',
        'outline-secondary' => 'btn-outline-secondary',
        'outline-success' => 'btn-outline-success',
        'outline-danger' => 'btn-outline-danger',
        'outline-warning' => 'btn-outline-warning',
        'outline-info' => 'btn-outline-info',
        'outline-light' => 'btn-outline-light',
        'outline-dark' => 'btn-outline-dark',
        'link' => 'btn-link',
        'pill' => 'btn-pill',
        'glass' => 'glass-effect',
        default => 'btn-primary'
    };
    
    $sizeClasses = match($size) {
        'sm' => 'btn-sm',
        'lg' => 'btn-lg',
        'xl' => 'btn-xl',
        default => ''
    };
    
    $disabledClass = $disabled ? 'disabled' : '';
    $loadingClass = $loading ? 'loading' : '';
    
    $allClasses = trim($baseClasses . ' ' . $variantClasses . ' ' . $sizeClasses . ' ' . $disabledClass . ' ' . $loadingClass . ' ' . $class);
@endphp

<{{ $type === 'link' ? 'a' : 'button' }} 
    @if($type !== 'link')
        type="{{ $type }}"
    @endif
    class="{{ $allClasses }}"
    @if($disabled)
        disabled
    @endif
    {{ $attributes }}
>
    @if($loading)
        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
    @elseif($icon && $iconPosition === 'left')
        <i class="{{ $icon }} me-2"></i>
    @endif
    
    {{ $slot }}
    
    @if($icon && $iconPosition === 'right')
        <i class="{{ $icon }} ms-2"></i>
    @endif
</{{ $type === 'link' ? 'a' : 'button' }}>

