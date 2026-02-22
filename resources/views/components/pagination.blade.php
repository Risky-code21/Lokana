@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-end pt-8">
        <div class="flex gap-2">
            {{-- 2. LOOPING NOMOR HALAMAN --}}
            @foreach ($elements as $element)
                {{-- Case A: "Three Dots" Separator (...) --}}
                @if (is_string($element))
                    <span class="px-3 py-2 text-gray-400 bg-white border border-gray-100 rounded-md text-base">
                        {{ $element }}
                    </span>
                @endif

                {{-- Case B: Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            {{-- STATE AKTIF (Warna Coklat Lokana) --}}
                            <span
                                class="px-4 py-2 bg-[#a0826d] text-white border border-[#a0826d] rounded-md text-base font-bold shadow-sm">
                                {{ $page }}
                            </span>
                        @else
                            {{-- STATE TIDAK AKTIF --}}
                            <a href="{{ $url }}"
                                class="px-4 py-2 bg-white text-[#555] border border-[#e0e0e0] rounded-md hover:bg-[#faf9f7] hover:border-[#a0826d] hover:text-[#a0826d] transition-all text-base font-medium">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

        </div>
    </nav>
@endif
