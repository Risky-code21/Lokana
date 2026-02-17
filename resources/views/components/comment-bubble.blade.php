@props(['comment'])

<div class="space-y-4 mb-6">
    {{-- 1. KOMENTAR UTAMA (PARENT) --}}
    <div class="flex gap-4 group">
        {{-- Avatar --}}
        <div
            class="flex-shrink-0 size-10 rounded-full bg-[#a9927d] text-white flex items-center justify-center font-serif text-base uppercase">
            {{ substr($comment->user->name, 0, 2) }}
        </div>

        <div class="flex-grow">
            <div class="flex justify-between items-start mb-1">
                <div>
                    <h4 class="font-serif font-bold text-[#4a4a4a] text-base">{{ $comment->user->name }}</h4>
                    <span class="text-xs text-gray-400 font-sans">{{ $comment->created_at->diffForHumans() }}</span>
                </div>

                {{-- Tombol Like (Placeholder/Logic Tambahan) --}}
                <button class="flex items-center gap-1.5 text-gray-500 hover:text-[#5e4b35] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-[#5e4b35]" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="text-xs font-bold text-[#555]">0</span> {{-- Ganti dengan $comment->likes_count jika ada --}}
                </button>
            </div>

            <p class="text-[#555] text-sm leading-relaxed font-sans mb-2">
                {{ $comment->content }}
            </p>

            {{-- Tombol Reply --}}
            {{-- Anda bisa menambahkan logic JS di sini untuk memunculkan form reply --}}
            <button class="text-xs text-gray-500 hover:text-[#5e4b35] font-medium transition"
                onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.toggle('hidden')">
                Reply ({{ $comment->replies->count() }})
            </button>
        </div>
    </div>

    {{-- 2. LOOPING BALASAN (REPLIES) --}}
    @if ($comment->replies->isNotEmpty())
        @foreach ($comment->replies as $reply)
            <div class="flex gap-4 ml-16 group border-l-2 border-gray-100 pl-4">
                {{-- Avatar Reply (Lebih Kecil) --}}
                <div
                    class="flex-shrink-0 w-10 h-10 rounded-full bg-primary-light text-white flex items-center justify-center font-serif text-base uppercase">
                    {{ substr($reply->user->name, 0, 2) }}
                </div>

                <div class="flex-grow">
                    <div class="flex justify-between items-start mb-1">
                        <div>
                            <h4 class="font-serif font-bold text-[#4a4a4a] text-base inline">{{ $reply->user->name }}
                            </h4>
                            {{-- Menampilkan 'replied to [Parent Name]' --}}
                            <span class="text-sm text-gray-400 font-serif italic ml-1">replied
                                {{ $comment->user->name }}</span>
                            <div class="text-xs text-gray-400 font-sans mt-0.5">
                                {{ $reply->created_at->diffForHumans() }}</div>
                        </div>

                        <button class="flex items-center gap-1.5 text-gray-500 hover:text-[#5e4b35] transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-[#5e4b35]" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-xs font-bold text-[#555]">0</span>
                        </button>
                    </div>

                    <p class="text-[#555] text-sm leading-relaxed font-sans mb-2">
                        {{ $reply->content }}
                    </p>
                </div>
            </div>
        @endforeach
    @endif
</div>
