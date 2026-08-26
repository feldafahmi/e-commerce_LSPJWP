<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? 'Panel Penjual | SHOP.CO' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#fafafa] font-sans text-zinc-950 antialiased">
        <div class="flex min-h-screen flex-col lg:flex-row">
            <aside class="flex w-full shrink-0 flex-col border-b border-zinc-200 bg-[#f3f3f3] p-5 lg:min-h-screen lg:w-64 lg:border-b-0 lg:border-r lg:p-6">
                <div class="flex items-center justify-between lg:block"><a class="text-2xl font-black tracking-[-0.09em]" href="{{ route('home') }}">SHOP.CO</a><span class="rounded-full bg-zinc-200 px-3 py-1 text-xs font-semibold text-zinc-600">Penjual</span></div>
                <div class="mt-8 hidden border-b border-zinc-300 pb-6 lg:block"><p class="text-lg font-bold">Panel Penjual</p><p class="text-sm text-zinc-500">Management Suite</p></div>
                <nav class="mt-6 flex gap-2 overflow-x-auto lg:flex-col" aria-label="Navigasi panel penjual"><a class="seller-nav-link {{ ($active ?? '') === 'products' ? 'seller-nav-active' : '' }}" href="{{ route('seller.products') }}"><span class="seller-nav-icon">▣</span> Produk</a><a class="seller-nav-link {{ ($active ?? '') === 'orders' ? 'seller-nav-active' : '' }}" href="{{ route('seller.orders') }}"><span class="seller-nav-icon">🛒</span> Order</a><a class="seller-nav-link" href="{{ route('home') }}"><span class="seller-nav-icon">⌂</span> Lihat Toko</a></nav>
                <a class="mt-auto hidden rounded-full bg-black px-5 py-3 text-center text-sm font-bold text-white transition hover:bg-zinc-700 lg:block" href="#">＋ Tambah Produk</a>
            </aside>
            <main class="min-w-0 flex-1 p-5 sm:p-8 lg:p-12">{{ $slot }}</main>
        </div>
    </body>
</html>
