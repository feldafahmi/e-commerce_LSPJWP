<!DOCTYPE html>
<html lang="id">
    <head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Pesanan | SHOP.CO</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
    <body class="bg-white font-sans text-zinc-950 antialiased"><x-storefront-header />
        <main class="mx-auto max-w-5xl px-5 py-10 lg:px-8"><a class="text-2xl font-black tracking-[-0.08em]" href="{{ route('home') }}">SHOP.CO</a><h1 class="mt-12 text-4xl font-black tracking-[-0.06em]">RIWAYAT PESANAN</h1>
            <div class="mt-8 space-y-4">@forelse ($orders as $order)<a class="block rounded-3xl border border-zinc-200 p-5 transition hover:border-black" href="{{ route('orders.show', $order) }}"><div class="flex flex-wrap justify-between gap-3"><strong>{{ $order->order_number }}</strong><span class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-semibold">{{ str_replace('_', ' ', $order->status) }}</span></div><p class="mt-3 text-sm text-zinc-500">{{ $order->created_at->format('d M Y, H:i') }}</p><p class="mt-2 font-bold">Rp{{ number_format($order->total_price, 0, ',', '.') }}</p></a>@empty<p class="rounded-3xl border border-dashed border-zinc-300 p-8 text-zinc-500">Belum ada pesanan.</p>@endforelse</div>{{ $orders->links() }}
        </main>
    </body>
</html>
