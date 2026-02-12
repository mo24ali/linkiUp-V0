<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl tracking-tight text-[#e7e9ea]">
                {{ __('Find Friends') }}
            </h2>
            <div class="flex items-center space-x-2">
                <span class="text-xs text-[#71767b] font-medium uppercase tracking-widest">Discovery Mode</span>
                <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-10">
        
        <livewire:test/>
      
    </div>
        
</x-app-layout>