@props([
    'type' => 'text',
    'name' => '',
    'label' => null,
    'placeholder' => '',
    'value' => '',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'class' => '',
    'labelClass' => '',
    'helpText' => null,
    'error' => null,
    'icon' => null,
    'iconPosition' => 'left'
])

@php
    $inputId = $name ?: 'input_' . uniqid();
    $hasError = $error || ($errors && $errors->has($name));
    $errorMessage = $error ?: ($errors ? $errors->first($name) : null);
    
    $inputClasses = 'form-control';
    if ($hasError) {
        $inputClasses .= ' is-invalid';
    }
    if ($class) {
        $inputClasses .= ' ' . $class;
    }
    
    $labelClasses = 'form-label fw-semibold';
    if ($required) {
        $labelClasses .= ' required';
    }
    if ($labelClass) {
        $labelClasses .= ' ' . $labelClass;
    }
@endphp

<div class="mb-3">
    @if($label)
        <label for="{{ $inputId }}" class="{{ $labelClasses }}">
            @if($icon)
                <i class="{{ $icon }} me-2 text-warning"></i>
            @endif
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif
    
    <div class="input-group">
        @if($icon && $iconPosition === 'left')
            <span class="input-group-text">
                <i class="{{ $icon }}"></i>
            </span>
        @endif
        
        <input
            type="{{ $type }}"
            id="{{ $inputId }}"
            name="{{ $name }}"
            class="{{ $inputClasses }}"
            placeholder="{{ $placeholder }}"
            value="{{ old($name, $value) }}"
            @if($required) required @endif
            @if($disabled) disabled @endif
            @if($readonly) readonly @endif
            {{ $attributes }}
        >
        
        @if($icon && $iconPosition === 'right')
            <span class="input-group-text">
                <i class="{{ $icon }}"></i>
            </span>
        @endif
    </div>
    
    @if($helpText)
        <div class="form-text">{{ $helpText }}</div>
    @endif
    
    @if($hasError)
        <div class="invalid-feedback">
            {{ $errorMessage }}
        </div>
    @elseif($required)
        <div class="invalid-feedback">
            لطفاً این فیلد را پر کنید
        </div>
    @endif
</div>

