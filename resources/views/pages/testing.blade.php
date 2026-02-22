<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0" />
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css' rel='stylesheet'
        type='text/css' />
    <title>{{ config('app.name') }} - Detail Article</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="container mx-auto px-4 py-8">

        <h1 class="text-2xl font-bold mb-6 text-gray-800">Tulis Artikel Baru</h1>

        {{-- Tampilkan Error Validasi --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- KOLOM KIRI: EDITOR & KONTEN --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Judul --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Artikel</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-main focus:ring-primary-main p-3 border"
                            placeholder="Contoh: Keindahan Tenun Ikat Bali...">
                    </div>

                    {{-- Short Description --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                        <textarea name="short_description" rows="3"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-main focus:ring-primary-main p-3 border"
                            placeholder="Rangkuman singkat untuk ditampilkan di card...">{{ old('short_description') }}</textarea>
                    </div>

                    {{-- FROALA EDITOR --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Konten Lengkap</label>
                        {{-- Textarea ini akan diubah oleh Froala --}}
                        <textarea id="example" name="content">{{ old('content') }}</textarea>
                    </div>
                </div>

                {{-- KOLOM KANAN: SETTINGS & THUMBNAIL --}}
                <div class="space-y-6">

                    {{-- Kategori --}}
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                        <select name="category_id" class="w-full rounded-md border-gray-300 p-2.5 border">
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Thumbnail Upload --}}
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Thumbnail Utama</label>

                        {{-- Preview Image (Javascript Simple) --}}
                        <div
                            class="mb-3 w-full h-40 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center border-2 border-dashed border-gray-300 relative">
                            <img id="img-preview" src="#" alt="Preview"
                                class="absolute inset-0 w-full h-full object-cover hidden">
                            <span id="placeholder-text" class="text-gray-400 text-sm">Upload Image</span>
                        </div>

                        <input type="file" name="thumbnail" id="thumbnail-input" accept="image/*"
                            class="block w-full text-sm text-slate-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-primary-light file:text-primary-main
                                  hover:file:bg-primary-100" />
                        <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, WebP. Max: 2MB.</p>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                        class="w-full bg-primary-main text-white font-bold py-3 px-4 rounded-lg hover:opacity-90 transition shadow-lg">
                        Terbitkan Artikel 🚀
                    </button>
                </div>
            </div>
        </form>
    </div>
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js'>
    </script>

    <script>
        // 1. Inisialisasi Froala Editor (Targetkan #example)
        var editor = new FroalaEditor('#example', {
            // Konfigurasi Upload Image
            imageUploadURL: "{{ route('admin.articles.upload_media') }}", // ✅ Nama Route Sesuai dengan web.php

            // Konfigurasi Header untuk CSRF Token Laravel
            requestHeaders: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}" // ✅ Format yang disukai Froala
            },

            imageUploadMethod: 'POST',

            // Opsional: Batasi ukuran
            imageMaxSize: 5 * 1024 * 1024, // 5MB
            imageAllowedTypes: ['jpeg', 'jpg', 'png', 'webp'],

            // Tinggi editor
            heightMin: 400,
            placeholderText: 'Mulai menulis cerita inspiratif di sini...',

            // Tambahkan event untuk memantau jika ada error
            events: {
                'image.error': function(error, response) {
                    console.log('Error Froala:', error);
                    console.log('Response Server:', response);
                }
            }
        });

        // 2. Script Preview Thumbnail (Biarkan sama persis seperti kode Anda)
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
