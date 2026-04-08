<nav class="flex mb-4" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        {{-- HOME: Selalu Ada --}}
        <li class="inline-flex items-center">
            <a href="{{ route('public.index') }}" class="inline-flex items-center text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-[#CD2828] transition-colors">
                <svg class="w-3 h-3 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                Home
            </a>
        </li>

        @foreach($links as $link)
            <li>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    
                    @if($loop->last || is_null($link['url']))
                        {{-- Jika terakhir ATAU URL-nya null: Tampilkan Teks Diam --}}
                        <span class="ml-1 text-[10px] font-black uppercase tracking-widest text-gray-800 md:ml-2 truncate max-w-[150px] md:max-w-none block">
                            {{ $link['name'] }}
                        </span>
                    @else
                        {{-- Jika ada URL: Ikuti URL yang dikirim Controller --}}
                        <a href="{{ $link['url'] }}" class="ml-1 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-[#CD2828] md:ml-2 transition-colors">
                            {{ $link['name'] }}
                        </a>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</nav>