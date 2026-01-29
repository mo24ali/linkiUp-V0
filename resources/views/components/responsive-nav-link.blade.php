@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-3 border-l-4 border-[#1d9bf0] text-base font-medium text-[#e7e9ea] bg-[#181818] focus:outline-none transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-3 border-l-4 border-transparent text-base font-medium text-[#71767b] hover:text-[#e7e9ea] hover:bg-[#181818] focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>