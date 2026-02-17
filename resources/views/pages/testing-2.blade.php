<!DOCTYPE html>
<html>

<head>
    {{-- Head sama seperti sebelumnya --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0" />
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css' rel='stylesheet'
        type='text/css' />
    <title>Edit Article</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Edit Artikel</h1>

        {{-- PERBAIKAN 1: Action ke route UPDATE dan tambahkan method PUT --}}
        {{-- Gunakan parameter $article->slug atau $article->id sesuai route definition --}}
        <form action="{{ route('articles.update', $article->slug) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT') {{-- WAJIB ADA UNTUK EDIT --}}

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- KOLOM KIRI --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Judul --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Artikel</label>
                        {{-- PERBAIKAN 2: Gunakan old('field', $default) yang lebih bersih --}}
                        <input type="text" name="title" value="{{ old('title', $article->title) }}"
                            class="w-full rounded-md border-gray-300 shadow-sm p-3 border">
                    </div>

                    {{-- Short Description --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                        <textarea name="short_description" rows="3" class="w-full rounded-md border-gray-300 shadow-sm p-3 border">{{ old('short_description', $article->short_description) }}</textarea>
                    </div>

                    {{-- FROALA EDITOR --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Konten Lengkap</label>
                        {{-- PERBAIKAN 3: Samakan ID dengan Script JS ('froala-editor') --}}
                        <textarea id="froala-editor" name="content">{{ old('content', $article->content) }}</textarea>
                    </div>
                </div>

                {{-- KOLOM KANAN --}}
                <div class="space-y-6">

                    {{-- Kategori --}}
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                        <select name="category_id" class="w-full rounded-md border-gray-300 p-2.5 border">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{-- Cek selected pakai ID --}}
                                    {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Thumbnail Upload --}}
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Thumbnail Utama</label>

                        {{-- PERBAIKAN 4: Logika Preview Gambar Lama --}}
                        @php
                            // Ambil gambar pertama dari relasi medias
                            $existingImage = $article->medias->first();
                            $imageUrl = $existingImage ? asset('storage/' . $existingImage->url) : '';
                        @endphp

                        <div
                            class="mb-3 w-full h-40 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center border-2 border-dashed border-gray-300 relative">
                            {{-- Jika ada gambar lama, HAPUS class hidden. Jika tidak ada, TAMBAH hidden --}}
                            <img id="img-preview" src="{{ $imageUrl }}" alt="Preview"
                                class="absolute inset-0 w-full h-full object-cover {{ $existingImage ? '' : 'hidden' }}">

                            {{-- Placeholder text muncul jika gambar tidak ada --}}
                            <span id="placeholder-text"
                                class="text-gray-400 text-sm {{ $existingImage ? 'hidden' : '' }}">
                                Upload Image
                            </span>
                        </div>

                        <input type="file" name="thumbnail" id="thumbnail-input" accept="image/*"
                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-primary-light file:text-primary-main hover:file:bg-primary-100" />
                    </div>

                    <button type="submit"
                        class="w-full bg-primary-main text-white font-bold py-3 px-4 rounded-lg hover:opacity-90 transition shadow-lg">
                        Simpan Perubahan 💾
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js'>
    </script>

    <script>
        // PERBAIKAN 5: Satukan inisialisasi JS dan pastikan ID-nya cocok (#froala-editor)
        new FroalaEditor('#froala-editor', {
            imageUploadURL: "{{ route('articles.upload_media') }}",
            imageUploadParams: {
                _token: "{{ csrf_token() }}"
            },
            imageUploadMethod: 'POST',
            imageMaxSize: 5 * 1024 * 1024,
            imageAllowedTypes: ['jpeg', 'jpg', 'png', 'webp'],
            heightMin: 400,
            placeholderText: 'Tulis konten di sini...',
        });

        // Script Preview Image (Tetap sama, logic logic hidden/show-nya sudah ditangani blade diatas)
        const thumbnailInput = document.getElementById('thumbnail-input');
        const imgPreview = document.getElementById('img-preview');
        const placeholderText = document.getElementById('placeholder-text');

        thumbnailInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imgPreview.src = e.target.result;
                    imgPreview.classList.remove('hidden');
                    placeholderText.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>
