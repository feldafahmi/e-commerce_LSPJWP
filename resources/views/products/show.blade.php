<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $product?->name ?? 'Produk' }} | SHOP.CO</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white font-sans text-zinc-950 antialiased">
        <x-storefront-header />
        <main class="mx-auto max-w-7xl px-5 py-8 lg:px-8">
            @if ($product)
                @php($image = $product->image && filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : ($product->image ? asset('storage/'.$product->image) : 'https://placehold.co/1000x1000/f0eeed/111?text=SHOP'))
                <nav class="mb-8 text-sm text-zinc-500"><a href="{{ route('home') }}">Beranda</a> <span aria-hidden="true">›</span> {{ $product->category?->name ?? 'Produk' }}</nav>
                <section class="grid gap-10 pb-16 lg:grid-cols-2"><div class="overflow-hidden rounded-3xl bg-[#f0eeed]"><img class="aspect-square w-full object-cover" src="{{ $image }}" alt="{{ $product->name }}"></div><div class="flex flex-col justify-center"><p class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-500">{{ $product->category?->name ?? 'Koleksi terbaru' }}</p><h1 class="mt-3 text-4xl font-black leading-none tracking-[-0.06em] sm:text-5xl">{{ $product->name }}</h1><p class="mt-5 text-3xl font-bold">Rp{{ number_format($product->price, 0, ',', '.') }}</p><p class="mt-5 border-b border-zinc-200 pb-6 text-sm leading-6 text-zinc-600">{{ $product->description ?: 'Produk pilihan dari penjual lokal.' }}</p><p class="py-5 text-sm text-zinc-500">Stok: <strong class="text-zinc-900">{{ $product->stock }}</strong></p><form method="POST" action="{{ route('cart.add', $product) }}">@csrf <button class="flex w-full items-center justify-center rounded-full bg-black px-5 py-3 text-sm font-bold text-white" type="submit">Tambah ke Keranjang <span class="ml-2">→</span></button></form></div></section>
            @else
                <section class="py-16"><p class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-500">Koleksi terbaru</p><h1 class="mt-3 text-4xl font-black">KEMEJA LINEN SANTAI</h1><p class="mt-5 text-3xl font-bold">Rp189.000</p><p class="mt-5 max-w-xl text-sm leading-6 text-zinc-600">Kemeja linen ringan dengan potongan relaxed yang nyaman dipakai sepanjang hari.</p><a class="mt-8 inline-flex rounded-full bg-black px-5 py-3 text-sm font-bold text-white" href="{{ route('cart') }}">Tambah ke Keranjang</a></section>
            @endif
            <section class="border-t border-zinc-200 py-10"><h2 class="text-3xl font-black tracking-[-0.05em]">MUNGKIN ANDA SUKA</h2></section>
        </main>
    </body>
</html>
