<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon_lokana.png') }}">
    <title>{{ config('app.name') }} - FAQ</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    @include('partials.navbar')

    <main class="page pb-16 mt-28">
        <div class="w-full h-fit overflow-x-auto max-w-[1600px] mx-auto px-4 sm:px-8 md:px-12 lg:px-56">

            <div id="faq-container"></div>

            <div class="mt-24 text-center">
                <div class="w-fit block mx-auto">
                    <img class="h-60 md:h-80 w-auto object-contain" src="{{ asset('images/maskot_faq.webp') }}"
                        alt="Lokana Logo" />
                </div>
                <h2 class="text-3xl md:text-4xl font-heading text-black font-semibold mb-8 tracking-wide">
                    Still Have Question?
                </h2>
                <a href="https://wa.me/+62361231213" class="btn-primary">
                    Chat on Whatsapp
                </a>
            </div>

        </div>
    </main>

    @include('partials.footer')

</body>

</html>
