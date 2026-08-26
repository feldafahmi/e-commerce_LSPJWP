<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Keranjang Belanja | SHOP.CO</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white font-sans text-zinc-950 antialiased">
        <x-storefront-header />
        <main class="mx-auto max-w-7xl px-5 py-8 lg:px-8 lg:py-12">
            <nav class="text-sm text-zinc-500"><a href="{{ route('home') }}">Beranda</a> <span>›</span> Keranjang</nav>
            <h1 class="mt-8 text-4xl font-black tracking-[-0.06em] sm:text-5xl">KERANJANG ANDA</h1>
            @if (session('success')) <p class="mt-5 rounded-xl bg-green-50 p-4 text-sm text-green-800">{{ session('success') }}</p> @endif
            @if ($errors->any()) <div class="mt-5 rounded-xl bg-red-50 p-4 text-sm text-red-800">{{ $errors->first() }}</div> @endif
            <div class="mt-8 grid items-start gap-5 lg:grid-cols-[minmax(0,1.5fr)_minmax(330px,0.8fr)]">
                <section class="rounded-3xl border border-zinc-200 px-5 sm:px-7" aria-label="Daftar produk di keranjang">
                    @forelse ($cart->items as $item)
                        @php($image = $item->product->image && filter_var($item->product->image, FILTER_VALIDATE_URL) ? $item->product->image : ($item->product->image ? asset('storage/'.$item->product->image) : 'https://placehold.co/400x400/f0eeed/111?text=SHOP'))
                        <article class="flex gap-4 border-b border-zinc-200 py-5 last:border-0 sm:gap-5"><img class="size-24 shrink-0 rounded-2xl bg-[#f0eeed] object-cover sm:size-32" src="{{ $image }}" alt="{{ $item->product->name }}"><div class="flex min-w-0 flex-1 flex-col"><div class="flex items-start justify-between gap-3"><div><h2 class="text-base font-bold sm:text-lg">{{ $item->product->name }}</h2><p class="mt-1 text-sm text-zinc-600">Rp{{ number_format($item->product->price, 0, ',', '.') }}</p><p class="mt-1 text-xs text-zinc-500">Stok: {{ $item->product->stock }}</p></div><form method="POST" action="{{ route('cart.remove', $item) }}">@csrf @method('DELETE')<button class="text-red-500" type="submit">Hapus</button></form></div><div class="mt-auto flex items-end justify-between gap-3 pt-4"><strong>Rp{{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}</strong><form class="flex items-center gap-3 rounded-full bg-zinc-100 px-4 py-2" method="POST" action="{{ route('cart.update', $item) }}">@csrf @method('PATCH')<input class="w-12 bg-transparent text-center" type="number" name="quantity" min="1" max="{{ $item->product->stock }}" value="{{ $item->quantity }}"><button class="text-sm font-semibold" type="submit">Ubah</button></form></div></div></article>
                    @empty
                        <p class="py-16 text-center text-zinc-500">Keranjang Anda masih kosong. <span class="font-semibold text-zinc-900">Lanjut ke Checkout</span></p>
                    @endforelse
                </section>
                <aside class="rounded-3xl border border-zinc-200 p-6 sm:p-7"><h2 class="text-2xl font-bold">Ringkasan Pesanan</h2><dl class="mt-7 space-y-5 text-sm"><div class="flex justify-between gap-4 text-zinc-600"><dt>Subtotal</dt><dd class="font-bold text-zinc-950">Rp{{ number_format($subtotal, 0, ',', '.') }}</dd></div><div class="flex justify-between gap-4 text-zinc-600"><dt>Biaya pengiriman</dt><dd class="font-bold text-zinc-950">Gratis</dd></div></dl><div class="my-6 h-px bg-zinc-200"></div><div class="flex justify-between gap-4 text-lg"><span>Total</span><strong>Rp{{ number_format($subtotal, 0, ',', '.') }}</strong></div>@if ($cart->items->isNotEmpty())<a class="mt-6 flex items-center justify-center rounded-full bg-black px-5 py-4 text-sm font-semibold text-white" href="{{ route('checkout') }}">Lanjut ke Checkout <span class="ml-2">→</span></a>@endif</aside>
            </div>
        </main>
    </body>
</html>
