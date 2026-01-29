<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register page</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{-- Body layouts --}}

<body class="bg-surface-medium flex w-full justify-center items-center h-dvh">
    {{-- Container layout --}}
    <main class="form-auth">
        {{-- Main content layout --}}
        @yield('main')
    </main>
    @stack('scripts')
    <script>
        document.addEventListener('click', function(e) {
            const button = e.target.closest('[data-button-toggle-password]');
            if (!button) return;

            const buttonTargetId = button.getAttribute('data-target');
            const inputPassword = document.getElementById(buttonTargetId);
            const eyeShow = button.querySelector('[data-eye-show]');
            const eyeHide = button.querySelector('[data-eye-hide]');

            const isPassword = inputPassword.type === 'password'
            inputPassword.type = isPassword ? 'text' : 'password'

            eyeShow.classList.toggle('hidden', !isPassword)
            eyeHide.classList.toggle('hidden', isPassword)
        })
    </script>
</body>

</html>
