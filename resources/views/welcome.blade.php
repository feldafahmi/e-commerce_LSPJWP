<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="SHOP.CO - marketplace untuk menemukan produk pilihan dari penjual lokal.">
        <title>SHOP.CO | Marketplace Pilihan</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white font-sans text-zinc-950 antialiased">
        <div class="bg-black px-5 py-2 text-center text-xs text-white sm:text-sm">
            Gratis ongkir untuk pesanan pertama Anda. <a class="ml-1 underline underline-offset-2" href="#produk">Belanja sekarang</a>
        </div>

        <header class="border-b border-zinc-200 bg-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-5 px-5 py-5 lg:px-8">
                <a class="text-2xl font-black tracking-[-0.08em] sm:text-3xl" href="{{ route('home') }}">SHOP.CO</a>
                <nav class="hidden items-center gap-7 text-sm font-medium lg:flex" aria-label="Navigasi utama">
                    <a class="transition hover:text-zinc-500" href="{{ route('home') }}">Beranda</a>
                    <a class="transition hover:text-zinc-500" href="#produk">Produk</a>
                    <a class="transition hover:text-zinc-500" href="#kategori">Kategori</a>
                </nav>
                <form class="hidden max-w-sm flex-1 md:block" role="search">
                    <label class="sr-only" for="product-search">Cari produk</label>
                    <div class="flex items-center gap-2 rounded-full bg-zinc-100 px-4 py-2.5 text-zinc-500">
                        <svg class="size-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="6"/><path d="m20 20-4-4"/></svg>
                        <input id="product-search" class="w-full bg-transparent text-sm outline-none placeholder:text-zinc-400" type="search" placeholder="Cari produk...">
                    </div>
                </form>
                <div class="flex items-center gap-2 text-sm font-semibold">
                    <a class="rounded-full px-4 py-2.5 transition hover:bg-zinc-100" href="/login">Masuk</a>
                    <a class="rounded-full bg-black px-4 py-2.5 text-white transition hover:bg-zinc-700" href="/register">Daftar</a>
                </div>
            </div>
        </header>

        <main>
            <section class="overflow-hidden bg-[#f2f0f1]">
                <div class="mx-auto grid max-w-7xl items-center gap-8 px-5 py-12 sm:py-16 lg:grid-cols-2 lg:px-8 lg:py-0">
                    <div class="relative z-10 max-w-xl lg:py-20">
                        <p class="mb-5 text-xs font-bold uppercase tracking-[0.22em] text-zinc-500">Marketplace Indonesia</p>
                        <h1 class="text-5xl font-black leading-[0.9] tracking-[-0.07em] sm:text-6xl lg:text-7xl">TEMUKAN PRODUK YANG SESUAI GAYA HIDUPMU</h1>
                        <p class="mt-6 max-w-md text-sm leading-6 text-zinc-600 sm:text-base">Jelajahi koleksi pilihan dari penjual lokal. Temukan produk berkualitas untuk kebutuhan sehari-hari Anda.</p>
                        <a class="mt-7 inline-flex items-center gap-2 rounded-full bg-black px-8 py-3.5 text-sm font-semibold text-white transition hover:bg-zinc-700" href="#produk">
                            Belanja Sekarang
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                        </a>
                        <dl class="mt-10 flex flex-wrap gap-y-5">
                            <div class="border-r border-zinc-300 pr-6 sm:pr-10"><dt class="text-2xl font-bold">200+</dt><dd class="mt-1 text-xs text-zinc-500">Penjual Lokal</dd></div>
                            <div class="border-r border-zinc-300 px-6 sm:px-10"><dt class="text-2xl font-bold">2.000+</dt><dd class="mt-1 text-xs text-zinc-500">Produk Pilihan</dd></div>
                            <div class="pl-6 sm:pl-10"><dt class="text-2xl font-bold">30.000+</dt><dd class="mt-1 text-xs text-zinc-500">Pelanggan Puas</dd></div>
                        </dl>
                    </div>
                    <div class="relative min-h-80 self-stretch lg:min-h-125">
                        <div class="absolute -right-12 bottom-0 h-full w-[115%] bg-[url('https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=1000&q=85')] bg-cover bg-top bg-no-repeat" role="img" aria-label="Koleksi fesyen kasual"></div>
                        <span class="absolute left-2 top-14 text-5xl">✦</span>
                        <span class="absolute right-4 top-9 text-6xl">✦</span>
                    </div>
                </div>
            </section>

            <section class="bg-black py-6 text-white">
                <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-around gap-x-10 gap-y-3 px-5 text-xl font-semibold tracking-[0.16em] sm:text-2xl">
                    <span>LOCAL MADE</span><span>ORIGINAL</span><span>TERPILIH</span><span>TERPERCAYA</span>
                </div>
            </section>

            <section id="produk" class="mx-auto max-w-7xl px-5 py-16 sm:py-22 lg:px-8">
                <div class="mb-9 flex items-end justify-between gap-4">
                    <div><p class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-500">Pilihan minggu ini</p><h2 class="mt-2 text-3xl font-black tracking-[-0.05em] sm:text-4xl">PRODUK TERBARU</h2></div>
                    <a class="text-sm font-semibold underline underline-offset-4" href="#">Lihat semua</a>
                </div>
                <div class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-4 sm:gap-x-5">
                    @foreach ([
                        ['Kemeja Linen Santai', 'Rp189.000', 'https://images.unsplash.com/photo-1598032895397-b9472444bf93?auto=format&fit=crop&w=600&q=85'],
                        ['Tas Kulit Esensial', 'Rp325.000', 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=600&q=85'],
                        ['Sneakers Harian', 'Rp429.000', 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=600&q=85'],
                        ['Jam Tangan Klasik', 'Rp279.000', 'https://images.unsplash.com/photo-1524805444758-089113d48a6d?auto=format&fit=crop&w=600&q=85'],
                    ] as [$name, $price, $image])
                        <article class="group">
                            <a class="block overflow-hidden rounded-2xl bg-[#f0eeed]" href="#"><img class="aspect-square w-full object-cover transition duration-500 group-hover:scale-105" src="{{ $image }}" alt="{{ $name }}"></a>
                            <h3 class="mt-3 text-sm font-bold sm:text-base">{{ $name }}</h3>
                            <div class="mt-1 flex items-center gap-1 text-xs text-amber-500"><span aria-hidden="true">★★★★★</span><span class="ml-1 text-zinc-500">4.8/5</span></div>
                            <p class="mt-1 font-bold">{{ $price }}</p>
                        </article>
                    @endforeach
                </div>
            </section>

            <section id="kategori" class="mx-auto max-w-7xl px-5 pb-16 lg:px-8 sm:pb-22">
                <div class="rounded-3xl bg-[#f0eeed] p-6 sm:p-10">
                    <h2 class="text-center text-3xl font-black tracking-[-0.05em] sm:text-4xl">BELANJA BERDASARKAN KATEGORI</h2>
                    <div class="mt-8 grid gap-4 sm:grid-cols-3">
                        <a class="group relative min-h-52 overflow-hidden rounded-2xl bg-white p-5" href="#"><img class="absolute inset-0 size-full object-cover opacity-80 transition duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=800&q=85" alt="Kategori fesyen"><span class="relative text-xl font-bold">Fesyen</span></a>
                        <a class="group relative min-h-52 overflow-hidden rounded-2xl bg-white p-5" href="#"><img class="absolute inset-0 size-full object-cover opacity-80 transition duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1556228720-195a672e8a03?auto=format&fit=crop&w=800&q=85" alt="Kategori kecantikan"><span class="relative text-xl font-bold">Kecantikan</span></a>
                        <a class="group relative min-h-52 overflow-hidden rounded-2xl bg-white p-5 sm:col-span-3" href="#"><img class="absolute inset-0 size-full object-cover opacity-80 transition duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1494438639946-1ebd1d20bf85?auto=format&fit=crop&w=1200&q=85" alt="Kategori rumah dan gaya hidup"><span class="relative text-xl font-bold">Rumah & Gaya Hidup</span></a>
                    </div>
                </div>
            </section>

            <section class="border-t border-zinc-200 py-16 sm:py-22">
                <div class="mx-auto max-w-7xl px-5 lg:px-8"><h2 class="text-3xl font-black tracking-[-0.05em] sm:text-4xl">APA KATA MEREKA</h2><div class="mt-8 grid gap-4 md:grid-cols-3">
                    @foreach ([['Nadia R.', 'Produk sesuai deskripsi dan pengiriman cepat. Pasti belanja lagi di sini!'], ['Bima A.', 'Pilihan produknya lengkap, tampilannya juga mudah digunakan.'], ['Sinta M.', 'Penjual responsif dan kualitas barangnya sangat memuaskan.']] as [$name, $review])
                        <figure class="rounded-2xl border border-zinc-200 p-6"><div class="text-amber-500" aria-label="Rating 5 dari 5">★★★★★</div><blockquote class="mt-4 text-sm leading-6 text-zinc-600">“{{ $review }}”</blockquote><figcaption class="mt-5 font-bold">{{ $name }} <span class="ml-1 text-emerald-600">●</span></figcaption></figure>
                    @endforeach
                </div></div>
            </section>
        </main>

        <footer class="bg-[#f0f0f0] pt-1">
            <div class="mx-auto max-w-7xl px-5 lg:px-8"><section class="grid gap-6 rounded-3xl bg-black p-7 text-white sm:grid-cols-[1.3fr_1fr] sm:items-center sm:p-10"><h2 class="max-w-md text-3xl font-black leading-none tracking-[-0.05em]">DAPATKAN INFO PRODUK DAN PROMO TERBARU</h2><form class="space-y-3"><label class="sr-only" for="newsletter-email">Email Anda</label><input id="newsletter-email" class="w-full rounded-full bg-white px-5 py-3 text-sm text-zinc-900 outline-none" type="email" placeholder="Masukkan alamat email"><button class="w-full rounded-full bg-white px-5 py-3 text-sm font-bold text-zinc-950 transition hover:bg-zinc-200" type="submit">Berlangganan Newsletter</button></form></section>
                <div class="grid gap-10 py-12 sm:grid-cols-2 lg:grid-cols-[2fr_1fr_1fr_1fr]"><div><a class="text-2xl font-black tracking-[-0.08em]" href="{{ route('home') }}">SHOP.CO</a><p class="mt-4 max-w-xs text-sm leading-6 text-zinc-600">Marketplace sederhana untuk menemukan produk pilihan dari para penjual lokal.</p></div><div><h3 class="text-xs font-bold tracking-[0.18em]">MARKETPLACE</h3><a class="mt-4 block text-sm text-zinc-600" href="{{ route('home') }}">Beranda</a><a class="mt-3 block text-sm text-zinc-600" href="#produk">Produk</a><a class="mt-3 block text-sm text-zinc-600" href="#kategori">Kategori</a></div><div><h3 class="text-xs font-bold tracking-[0.18em]">AKUN</h3><a class="mt-4 block text-sm text-zinc-600" href="/login">Masuk</a><a class="mt-3 block text-sm text-zinc-600" href="/register">Daftar</a></div><div><h3 class="text-xs font-bold tracking-[0.18em]">BANTUAN</h3><span class="mt-4 block text-sm text-zinc-600">Pusat Bantuan</span><span class="mt-3 block text-sm text-zinc-600">Syarat & Ketentuan</span></div></div>
                <div class="border-t border-zinc-300 py-6 text-xs text-zinc-500">SHOP.CO © {{ now()->year }}. Semua hak dilindungi.</div>
            </div>
        </footer>
    </body>
</html>
