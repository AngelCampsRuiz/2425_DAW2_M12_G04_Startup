{{-- Componente Breadcrumb --}}
<div class="bg-white shadow-sm mb-6">
    <div class="container mx-auto px-4 py-3">
        <div class="flex items-center text-sm overflow-x-auto whitespace-nowrap">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-[#5e0490] transition-colors">
                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Inicio
            </a>
            
            <!-- Debug: {{ $items ?? 'No items' }} -->
            
            @if(isset($items) && !empty(json_decode($items, true)))
                @foreach(json_decode($items, true) as $item)
                    <span class="mx-2 text-gray-400">/</span>
                    @if(isset($item['route']))
                        <a href="{{ route($item['route']) }}" class="text-gray-500 hover:text-[#5e0490] transition-colors">
                            {{ $item['name'] }}
                        </a>
                    @else
                        <span class="text-[#5e0490] font-medium">{{ $item['name'] }}</span>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</div> 