@props([
    'id' => '',
    'title' => '',
    'size' => 'md',
    'centered' => true,
    'scrollable' => false,
    'backdrop' => true,
    'keyboard' => true,
    'class' => ''
])

@php
    $modalId = $id ?: 'modal_' . uniqid();
    
    $modalClasses = 'modal fade';
    if ($class) {
        $modalClasses .= ' ' . $class;
    }
    
    $dialogClasses = 'modal-dialog';
    if ($size !== 'md') {
        $dialogClasses .= ' modal-' . $size;
    }
    if ($centered) {
        $dialogClasses .= ' modal-dialog-centered';
    }
    if ($scrollable) {
        $dialogClasses .= ' modal-dialog-scrollable';
    }
    
    $backdropAttr = $backdrop ? 'true' : 'false';
    $keyboardAttr = $keyboard ? 'true' : 'false';
@endphp

<div 
    class="{{ $modalClasses }}" 
    id="{{ $modalId }}" 
    tabindex="-1" 
    aria-labelledby="{{ $modalId }}Label" 
    aria-hidden="true"
    data-bs-backdrop="{{ $backdropAttr }}"
    data-bs-keyboard="{{ $keyboardAttr }}"
>
    <div class="{{ $dialogClasses }}">
        <div class="modal-content">
            @if($title || $header)
                <div class="modal-header">
                    @if($title)
                        <h5 class="modal-title" id="{{ $modalId }}Label">{{ $title }}</h5>
                    @endif
                    {{ $header }}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="modal-body">
                {{ $slot }}
            </div>
            
            @if($footer)
                <div class="modal-footer">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>

