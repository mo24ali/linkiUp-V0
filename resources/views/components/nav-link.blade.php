@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-4 py-2 text-sm font-medium rounded-full transition-colors bg-black text-[#e7e9ea]'
            : 'inline-flex items-center px-4 py-2 text-sm font-medium rounded-full transition-colors text-[#71767b] hover:text-[#e7e9ea] hover:bg-[#181818]';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>