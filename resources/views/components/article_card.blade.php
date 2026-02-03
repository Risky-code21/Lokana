@props([
    'thumbnail' => null,
    'category' => 'article',
    'title' => 'title',
    'created_at' => null,
    'views' => null,
    'likes' => null,
    'short-description' => null,
    'author_photo' => null,
    'author_name' => 'author',
    'author_division' => 'division',
])
<div class="overflow-hidden flex-1 shadow-md w-[411] rounded-card">
    {{-- Thumbnail artike; --}}
    <div class="w-full h-40 overflow-hidden ">
        <img src="https://images.unsplash.com/photo-1636693391484-6829643bc75e?q=80&w=1631&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
            alt="" class="size-full object-cover object-center" />
    </div>

    {{-- Deskripsi artikel --}}
    <main class="space-y-3 p-5 bg-white">
        {{-- Kategori artikel --}}
        <span
            class="py-1 px-2 text-white text-sm block w-fit rounded-md bg-primary-light border border-primary-border">Handcraft</span>

        {{-- Judul artikel --}}
        <h1 class="text-xl">Bali's Traditional Craft</h1>

        {{-- Informasi tambahan artikel --}}
        <div class="flex items-center gap-3 text-slate-400 text-sm">
            {{-- Tanggal rilis --}}
            <span class="text-inherit">18 July 2025</span>

            {{-- Banyak views --}}
            <div class="size-1 bg-slate-400 rounded-full"></div>
            <span class="text-inherit">6,2k views</span>

            {{-- Banyak likes --}}
            <div class="size-1 bg-slate-400 rounded-full"></div>
            <span class="text-inherit">1,2k likes</span>
        </div>

        {{-- Short description --}}
        <p class="text-slate-400 max-w-md">At Bali's Craft, we believe that greatness starts from small, meaningful
            steps.
            Established in, we are a
            local.</p>

        {{-- Author article --}}
        <div class="flex gap-3 mt-10">
            <div class="size-10 overflow-hidden rounded-full">
                <img src="https://images.unsplash.com/photo-1564564244660-5d73c057f2d2?q=80&w=1176&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    alt="" class="size-full object-cover object-center" />
            </div>

            <div class="space-y-0.5">
                <p class="text-primary-main leading-none">Irdaus Irman</p>
                <p class="text-slate-400">Admin lokana</p>
            </div>
        </div>

        {{-- CTA view article --}}
        <a href="" class="btn-primary block text-center">Read more</a>
    </main>
</div>
