@props(['textColor', 'bgColor'])

@php
    $textColor = match ($textColor) {
        'gray' => 'text-gray-800', 
        'yellow' => 'text-yellow-800', 
        'blue' => 'text-blue-800',  
        'red' => 'text-red-900',  
        default => 'text-gray-300'
    };

    $bgColor = match ($bgColor) {
        'gray' => 'bg-gray-200', 
        'yellow' => 'bg-yellow-100', 
        'blue' => 'bg-blue-100',  
        'red' => 'bg-red-100',  
        default => 'bg-red-700'
    };
@endphp

<button {{ $attributes }} class="{{ $textColor }} {{ $bgColor }} rounded-xl px-3 py-1 text-base">
    {{ $slot }}
</button>