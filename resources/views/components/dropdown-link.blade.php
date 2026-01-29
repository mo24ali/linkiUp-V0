@props(['href' => '#'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'block px-4 py-2 text-sm text-[#e7e9ea] hover:bg-[#181818] transition-colors duration-150']) }}>
    {{ $slot }}
</a>