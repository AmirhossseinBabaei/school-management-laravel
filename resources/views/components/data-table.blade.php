@props([
    'headers' => [],
    'data' => [],
    'class' => '',
    'striped' => true,
    'hover' => true,
    'bordered' => false,
    'responsive' => true
])

@php
    $tableClasses = 'table';
    
    if ($striped) {
        $tableClasses .= ' table-striped';
    }
    
    if ($hover) {
        $tableClasses .= ' table-hover';
    }
    
    if ($bordered) {
        $tableClasses .= ' table-bordered';
    }
    
    if ($class) {
        $tableClasses .= ' ' . $class;
    }
@endphp

@if($responsive)
    <div class="table-responsive">
@endif

<table class="{{ $tableClasses }}">
    @if($headers)
        <thead>
            <tr>
                @foreach($headers as $header)
                    <th scope="col">{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
    @endif
    
    <tbody>
        @if($data)
            @foreach($data as $row)
                <tr>
                    @foreach($row as $cell)
                        <td>{{ $cell }}</td>
                    @endforeach
                </tr>
            @endforeach
        @else
            {{ $slot }}
        @endif
    </tbody>
</table>

@if($responsive)
    </div>
@endif

