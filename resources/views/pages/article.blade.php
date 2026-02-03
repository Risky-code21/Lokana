<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Article</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-surface-high flex items-center justify-center w-full h-screen">
    <div class="w-full grid grid-cols-3 p-20 gap-6">
        <x-article_card />
        <x-article_card />
        <x-article_card />
    </div>
</body>

</html>
