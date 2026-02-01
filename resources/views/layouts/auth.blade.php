<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - @yield('title', 'auth')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{-- Body layouts --}}

{{-- Body element layout --}}

<body class="bg-surface-medium flex w-full justify-center items-center h-dvh">
    {{-- Container layout --}}
    <main class="form-auth">
        {{-- Custom error untuk menampilkan error umum --}}
        @error('error')
            <div class="error-status-primary">
                <x-heroicon-s-exclamation-circle class="size-5" />
                <p class="text-inherit m-0"> {{ $message }} </p>
            </div>
        @enderror
        {{-- Main content layout --}}
        @yield('main')
    </main>

    {{-- Stack script, jadi file blade yang extend layout ini bisa menambahkan script untuk halaman mereka sendiri --}}
    @stack('scripts')
    {{-- Script untuk menampilkan dan menyembunyikan password yang sedang dimasukan oleh pengguna --}}
    <script>
        // Event listener untuk mendeteksi klik pada document
        document.addEventListener('click', function(e) {
            // Menggunakan event delegation untuk mendeteksi klik pada button toggle password
            const button = e.target.closest('[data-button-toggle-password]');
            if (!button) return;

            // Seleksi elemen HTML yang akan dimanipulasi dalam proses ini
            const buttonTargetId = button.getAttribute('data-target');
            const inputPassword = document.getElementById(buttonTargetId);
            const eyeShow = button.querySelector('[data-eye-show]');
            const eyeHide = button.querySelector('[data-eye-hide]');

            // Toggle type input password antara 'password' dan 'text'
            const isPassword = inputPassword.type === 'password'
            inputPassword.type = isPassword ? 'text' : 'password'

            eyeShow.classList.toggle('hidden', !isPassword)
            eyeHide.classList.toggle('hidden', isPassword)
        })
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // 1. Cek apakah ada error specific Rate Limit?
            // Kita cari text error di layar yang mengandung kata "Tunggu" atau "seconds"
            // (Sesuaikan dengan pesan di AppServiceProvider Anda)

            const errorText = document.body.innerText;

            // Cek jika ada pesan error validasi email yang mengandung angka detik
            // Regex sederhana untuk menangkap angka di pesan "Tunggu 55 detik"
            const waitMatch = errorText.match(/too many attempts, try again later./);

            if (waitMatch) {
                const secondsToWait = parseInt(waitMatch[1]);
                const btn = document.getElementById('btn-submit-form');
                const inputs = document.querySelectorAll('input');

                // 2. Matikan Tombol & Input
                btn.disabled = true;
                inputs.forEach(input => input.disabled = true);

                let counter = 60;
                const originalText = btn.innerText;

                // 3. Hitung Mundur
                const interval = setInterval(() => {
                    btn.innerText = `wait for ${counter}s...`;
                    counter--;

                    if (counter < 0) {
                        // 4. Hidupkan Kembali saat waktu habis
                        clearInterval(interval);
                        btn.disabled = false;
                        inputs.forEach(input => input.disabled = false);
                        btn.innerText = originalText;
                    }
                }, 1000);
            }
        });
    </script>
</body>

</html>
