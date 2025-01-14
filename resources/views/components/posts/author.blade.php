@props(['author', 'size'])

@php
    $imageSize = match ($size ?? null) {
        'xs' => 'h-7 w-7',
        'sm' => 'h-9 w-9',
        'md' => 'h-10 w-10',
        'lg' => 'h-14 w-14',
        default => 'h-10 w-10'
    };
    $textSize = match ($size ?? null) {
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        'md' => 'text-base',
        'lg' => 'text-lg',
        default => 'text-base'
    };
@endphp

    <img class="{{ $imageSize }} rounded-full mr-3"
                    src="{{ $author->profile_photo_url }}"
                    alt="{{ $author->name }}">
    <span class="mr-1 {{ $textSize }}">{{ $author->name }}</span>
