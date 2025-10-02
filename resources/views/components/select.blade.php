@props([
    'name' => '',
    'label' => null,
    'options' => [],
    'value' => '',
    'required' => false,
    'disabled' => false,
    'class' => '',
    'labelClass' => '',
    'helpText' => null,
    'error' => null,
    'icon' => null,
    'placeholder' => null,
    'multiple' => false
])

@php
    $selectId = $name ?: 'select_' . uniqid();
    $hasError = $error || ($errors && $errors->has($name));
    $errorMessage = $error ?: ($errors ? $errors->first($name) : null);
    
    $selectClasses = 'form-select';
    if ($hasError) {
        $selectClasses .= ' is-invalid';
    }
    if ($class) {
        $selectClasses .= ' ' . $class;
    }
    
    $labelClasses = 'form-label fw-semibold';
    if ($required) {
        $labelClasses .= ' required';
    }
    if ($labelClass) {
        $labelClasses .= ' ' . $labelClass;
    }
    
    $currentValue = old($name, $value);
@endphp

<div class="mb-3">
    @if($label)
        <label for="{{ $selectId }}" class="{{ $labelClasses }}">
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
        @if($icon)
            <span class="input-group-text">
                <i class="{{ $icon }}"></i>
            </span>
        @endif
        
        <select
            id="{{ $selectId }}"
            name="{{ $name }}{{ $multiple ? '[]' : '' }}"
            class="{{ $selectClasses }}"
            @if($required) required @endif
            @if($disabled) disabled @endif
            @if($multiple) multiple @endif
            {{ $attributes }}
        >
            @if($placeholder)
                <option value="">{{ $placeholder }}</option>
            @endif
            
            @foreach($options as $optionValue => $optionLabel)
                <option 
                    value="{{ $optionValue }}"
                    @if($multiple)
                        {{ in_array($optionValue, (array)$currentValue) ? 'selected' : '' }}
                    @else
                        {{ $currentValue == $optionValue ? 'selected' : '' }}
                    @endif
                >
                    {{ $optionLabel }}
                </option>
            @endforeach
        </select>
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
            لطفاً یک گزینه انتخاب کنید
        </div>
    @endif
</div>

