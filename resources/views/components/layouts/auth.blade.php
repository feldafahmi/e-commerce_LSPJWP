<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? 'SHOP.CO' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#f7f7f7] px-5 py-8 font-sans text-zinc-950 sm:py-12">
        <main class="mx-auto flex min-h-[calc(100vh-6rem)] max-w-md items-center justify-center">
            <section class="w-full rounded-[2rem] border border-zinc-200 bg-white p-7 shadow-[0_8px_30px_rgba(0,0,0,0.03)] sm:p-10">
                <a class="block text-center text-3xl font-black tracking-[-0.09em]" href="{{ route('home') }}">SHOP.CO</a>
                {{ $slot }}
            </section>
        </main>
    </body>
</html>
