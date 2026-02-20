{{-- Props untuk mengambil data dari model comments yang masuk dan data dari article slug --}}
@props(['comment', 'articleSlug'])

@php
    // Sistem untuk fallback user yang sebelumnya dibuat saat belum berisi casting avatar pada modelnya
    // Menggambil data pengguna yang sedang login saat ini
    $currentUserId = auth()->id();

    // Function casting semu pada avatar user
    $isLiked = fn($model) => $model->likes()->where('user_id', $currentUserId)->exists();

    // Function untuk cek apakah user yang login saat ini sudah melakukan like pada suatu komentar yang ada disini, entah komentar replay ataupun komentar utama
    $smartAvatar = fn($model) => $model->user->avatar ??
        'https://ui-avatars.com/api/?name=' . urlencode($model->user->name);

@endphp

<div x-data="{
    {{-- Inisiasi kebetuhan komponent dengan alpine js --}}
    isReplying: false,
        {{-- State untuk memunculkan form editing komentar --}}
    isEditing: false,
        {{-- Insiasi isi input pada form komentar --}}
    editContent: '{{ $comment->content }}',
        {{-- Stata untuk menampilkan dropdown reply komentar --}}
    showReplies: false,
        {{-- Targeting replied komentar dan parent komentar --}}
    replyTargetId: '',
        replyTargetName: '',

        {{-- Semacam onstructor function untuk menginisiasi variable atau state yang diperlukan --}}
    setupReply(id, name) {
            this.isReplying = true;
            this.replyTargetId = id;
            this.replyTargetName = name;
            $nextTick(() => { $refs.replyInput.focus(); });
        },

        {{-- Function untuk gulir komentar sesuai komentar yang di reply --}}
    scrollToTarget(id) {
        const el = document.getElementById('comment-' + id);
        if (el) {
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            el.classList.add('bg-primary-light/20', 'transition-colors', 'duration-1000');
            setTimeout(() => el.classList.remove('bg-primary-light/20'), 1000);
        }
    },
}" class="space-y-4 mb-6" id="comment-{{ $comment->id }}">

    {{-- Komentar utama atau parent komentar --}}
    <div class="flex gap-4 group relative">
        {{-- Avatar user, menggunakan sistem smart avatar yang telah dibuat sebelumnya --}}
        <div class="size-10 flex-shrink-0 overflow-hidden rounded-full">
            <img src="{{ $smartAvatar($comment) }}" class="size-full object-cover" />
        </div>

        {{-- Container penyusun informasi serta content komentar utama --}}
        <div class="flex-grow">
            {{-- Header komentar utama --}}
            <div class="flex justify-between items-start mb-1">

                {{-- Informasi pembuat komentar --}}
                <div>
                    {{-- Nama pembuat komentar --}}
                    <h4 class="text-primary-main text-base font-bold">{{ $comment->user->name }}</h4>

                    {{-- Kapan komentar dirilis --}}
                    <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                </div>

                {{-- CTA  --}}
                <div class="flex items-center gap-3">

                    {{-- CTA untuk toggle like  --}}
                    <form action="{{ route('likes.toggle', ['type' => 'comment', 'slug' => $comment->id]) }}"
                        method="POST" class="flex items-center gap-1">
                        @csrf
                        {{-- Membaca status like berdasarkan variable is liked  yang sudah dibuat sebelumnya --}}
                        <button type="submit"
                            class="transition transform hover:scale-110 {{ $isLiked($comment) ? 'text-red-500' : 'text-gray-400 hover:text-red-500' }}">
                            @if ($isLiked($comment))
                                <x-heroicon-s-heart class="size-4" />
                            @else
                                <x-heroicon-o-heart class="size-4" />
                            @endif
                        </button>

                        {{-- Jumlah likes --}}
                        <span class="text-xs font-semibold text-[#555]">{{ $comment->likes_count }}</span>
                    </form>

                    {{-- Menu delete komentar berdasarkan pengguna yang sedang login dan apakah pengguna tersebut yang mempunyai komentar yang sedang dinteraksikan sekarang --}}
                    <div x-show="currentViewerId === {{ $comment->user_id }}" x-data="{ open: false }" class="relative">

                        {{-- Opsi lanjutan untuk membuka container yang memuat trigger button dibawah --}}
                        <button @click="open = !open" @click.outside="open = false"
                            class="text-gray-400 hover:text-primary-main">
                            <x-heroicon-m-ellipsis-vertical class="size-5" />
                        </button>

                        {{-- Container yang berisi trigger button untuk open edit menu dan delete  --}}
                        <div x-show="open" style="display: none;"
                            class="absolute right-0 mt-1 w-28 bg-white border border-gray-100 rounded shadow-lg z-10">

                            {{-- Trigger edit form --}}
                            <button @click="isEditing = true; open = false"
                                class="block w-full text-left px-4 py-2 text-xs hover:bg-gray-50">Edit</button>

                            {{-- Delete button didalam form --}}
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                {{-- Handle konfirmasi sebelum request di submit --}} onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button
                                    class="block w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Content komentar utama --}}
            <div>
                {{-- Konten dari komentar utama --}}
                <p x-show="!isEditing" class="text-primary-main text-sm leading-relaxed">{{ $comment->content }}</p>

                {{-- Edit komentar utama --}}
                <div x-show="isEditing" @click.outside="isEditing = false" style="display: none;" class="mt-2">
                    <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                        @csrf @method('PUT')
                        <textarea x-model="editContent" name="content" rows="2" class="w-full p-2 text-xs border rounded"></textarea>
                        <div class="flex justify-end gap-2 mt-1">
                            <button type="button" @click="isEditing = false"
                                class="text-sm p-2 px-4 text-gray-400">Cancel</button>
                            <button type="submit"
                                class="text-sm p-2 px-4 bg-primary-main text-white py-0.5 rounded">Save</button>
                        </div>
                    </form>
                </div>

                {{-- Trigger button untuk reply komentar --}}
                <div class="flex items-center gap-4 mt-2">
                    <button class="text-xs text-gray-500 hover:text-primary-main font-reguler"
                        @click="setupReply('{{ $comment->id }}', '{{ $comment->user->name }}')">
                        Reply
                    </button>

                    @if ($comment->replies->count() > 0)
                        <button @click="showReplies = !showReplies"
                            class="text-xs text-primary-main font-bold flex items-center gap-1">
                            <span
                                x-text="showReplies ? 'Hide Replies' : 'View {{ $comment->replies->count() }} Replies'"></span>
                            <x-heroicon-m-chevron-down class="size-3 transition-transform" ::class="showReplies ? 'rotate-180' : ''" />
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Container untuk memuat reply komentar dari parent komentar atau reply lain yang masih satu scope dengan parent komentar --}}
    @if ($comment->replies->isNotEmpty())
        {{-- Container reply --}}
        <div x-show="showReplies" x-transition class="border-l-2 w-auto border-gray-100 pl-4 mt-4 ml-16 space-y-4">
            {{-- Looping untuk data reply --}}
            @foreach ($comment->replies as $reply)
                @php
                    // Sistem untuk menangkap nama dari replied komentar atau komentar yang di reply agar menyesuaikan dengan nama pengomentar tersebut jika tidak gunakan parent komentar user name saja.
                    $targetName = $reply->target ? $reply->target->user->name : $comment->user->name;

                    // Jika replied target tidak ada, dia otomatis menjadi replyer pertama pada suatu komentar parent
                    $targetId = $reply->reply_target_id ?? $comment->id;
                @endphp

                <div id="comment-{{ $reply->id }}" x-data="{ isChildEditing: false, childEditContent: '{{ $reply->content }}' }" class="flex gap-4 group">

                    {{-- Avatar untuk komentar reply --}}
                    <div class="size-10 flex-shrink-0 overflow-hidden rounded-full">
                        <img src="{{ $smartAvatar($reply) }}" class="size-full object-cover" />
                    </div>

                    {{-- informasi tentang komentar --}}
                    <div class="flex-grow">
                        {{-- Informasi pembuat komentar, informasi dibuatnya komentar, serta scroll ke target komentar yang di reply --}}
                        <div class="flex justify-between items-start mb-1">
                            <div>
                                {{-- nama user yang menjadi replyaer komentar --}}
                                <h4 class="font-bold text-primary-main text-base inline">{{ $reply->user->name }}</h4>
                                {{-- Trigger scroll ke replied komentar --}}
                                <span class="text-sm text-gray-400 ml-1 cursor-pointer hover:text-primary-main"
                                    @click="scrollToTarget('{{ $targetId }}')">
                                    <x-heroicon-m-arrow-turn-up-left class="size-4 inline mr-0.5" />
                                    replied {{ $targetName }}
                                </span>
                                {{-- Informasi mengenai waktu pembuatan komentar --}}
                                <div class="text-xs text-gray-400">{{ $reply->created_at->diffForHumans() }}</div>
                            </div>

                            {{-- CTA --}}
                            <div class="flex items-center gap-2">

                                {{-- Toggle like --}}
                                <form action="{{ route('likes.toggle', ['type' => 'comment', 'slug' => $reply->id]) }}"
                                    class="flex items-center gap-1" method="POST">
                                    @csrf
                                    <button
                                        class="{{ $isLiked($reply) ? 'text-red-500' : 'text-gray-400 hover:text-red-500' }}">
                                        @if ($isLiked($reply))
                                            <x-heroicon-s-heart class="size-4" />
                                        @else
                                            <x-heroicon-o-heart class="size-4" />
                                        @endif
                                    </button>

                                    <span class="text-xs font-semibold text-[#555]">{{ $reply->likes_count }}</span>
                                </form>


                                {{-- Trigger edit dan delete container --}}
                                @if ($reply->user_id === $currentUserId)
                                    <div x-data="{ open: false }" class="relative">
                                        <button @click="open = !open" @click.outside="open = false"
                                            class="text-gray-400 hover:text-primary-main">
                                            <x-heroicon-m-ellipsis-vertical class="size-4" />
                                        </button>
                                        <div x-show="open" style="display: none;"
                                            class="absolute right-0 w-28 bg-white rounded shadow z-10">
                                            <button @click="isChildEditing = true; open = false"
                                                class="block w-full text-left px-4 py-2 text-xs hover:bg-gray-50">Edit</button>

                                            <form action="{{ route('comments.destroy', $reply->id) }}" method="POST"
                                                onsubmit="return confirm('Delete?')">
                                                @csrf @method('DELETE')
                                                <button
                                                    class="block w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Content dari reply komentar serta button trigger untuk reply komentar lain dalam scope parent saat ini --}}
                        <div x-show="!isChildEditing">
                            {{-- Content, yang dimana untuk kata yang berisi @ akan diberikan highlisht, namun fitur ini untuk saat ini tidak diperlukan dahulu, cukup tampilkan konten biasa karena redundan dengan scroll trigger sebelumnya --}}
                            <p class="text-gray-600 text-sm leading-relaxed mb-1">
                                {!! preg_replace('/(@\w+)/', '<span class="text-primary-main font-bold">$1</span>', e($reply->content)) !!}
                            </p>

                            {{-- Trigger reply --}}
                            <button class="text-xs text-gray-500 hover:text-primary-main font-reguler"
                                @click="setupReply('{{ $reply->id }}', '{{ $reply->user->name }}')">
                                Reply
                            </button>
                        </div>

                        {{-- Edit form komentar reply --}}
                        <div x-show="isChildEditing" @click.outside="isChildEditing = false" style="display: none;"
                            class="mt-2">
                            <form action="{{ route('comments.update', $reply->id) }}" method="POST">
                                @csrf @method('PUT')
                                <textarea x-model="childEditContent" name="content" rows="2" class="w-full p-2 text-xs border rounded"></textarea>
                                <div class="flex justify-end gap-2 mt-1">
                                    <button type="button" @click="isChildEditing = false"
                                        class="text-sm p-2 px-4 text-gray-400">Cancel</button>
                                    <button type="submit"
                                        class="text-sm p-2 px-4 bg-primary-main text-white px-2 py-0.5 rounded">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Form untuk reply yang akan muncul ketika trigger button di tekan --}}
    <div x-show="isReplying" @click.outside="isReplying = false" x-transition class="mt-4 relative z-20"
        style="display: none;">
        @auth
            <form @submit.prevent="submitKomentar"
                action="{{ route('comments.store', ['type' => 'article', 'slug' => $articleSlug]) }}" method="POST">
                @csrf
                {{-- Untuk membuat scope khusus, karena kita memerlukan parent id untuk tracking jumlah reply dari parent ini walau yang di reply tidak selalu parent, bisa jadi juga reply komentar reply lain yang intinya masih satu scope dengan parent saat ini. --}}
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">

                {{-- Untuk nedbdapatkan kepada siapa komentar ini diberikan atau komentar ini mereply siapa, karena walau dalam satu parent yang sama, yang di reply bisa saja komentar reply bukan parentnya --}}
                <input type="hidden" name="reply_target_id" x-model="replyTargetId">

                <div class="mb-3">
                    {{-- Label penanda kita akan mereply komentar yang mana dan milik siapa --}}
                    <label class="text-xs text-gray-500 block mb-2">Replying to <span class="font-bold text-primary-main"
                            x-text="replyTargetName"></span></label>
                    <textarea x-ref="replyInput" name="content" rows="2"
                        class="w-full p-3 text-sm border rounded-lg focus:border-primary-main outline-none" required></textarea>
                </div>

                {{-- Tombol cancel dan accept --}}
                <div class="flex justify-end gap-3">
                    <button type="button" @click="isReplying = false" class="text-xs text-gray-500">Cancel</button>
                    <button type="submit" class="bg-primary-main text-white px-4 py-2 rounded-lg text-xs font-bold">Post
                        Reply</button>
                </div>
            </form>
        @else
            {{-- Karena fitur komentar ini hanya bisa digunakan ketika pengguna sudah login, maka ini adalah pengecualian ketika pengguna belum login --}}
            <div class="text-center text-xs text-gray-500">Please login to reply.</div>
        @endauth
    </div>
</div>
