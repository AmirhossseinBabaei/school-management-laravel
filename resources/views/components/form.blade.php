@props([
    'method' => 'POST',
    'action' => '',
    'enctype' => 'application/x-www-form-urlencoded',
    'class' => '',
    'novalidate' => true
])

@php
    $formAttributes = [
        'method' => $method === 'GET' ? 'GET' : 'POST',
        'action' => $action,
        'enctype' => $enctype,
        'class' => 'needs-validation ' . $class,
    ];
    
    if ($novalidate) {
        $formAttributes['novalidate'] = true;
    }
@endphp

<form {{ $attributes->merge($formAttributes) }}>
    @if($method !== 'GET')
        @csrf
    @endif
    
    @if($method === 'PUT' || $method === 'PATCH' || $method === 'DELETE')
        @method($method)
    @endif
    
    {{ $slot }}
</form>

