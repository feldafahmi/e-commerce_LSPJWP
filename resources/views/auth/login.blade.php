<x-layouts.auth :title="'Masuk | SHOP.CO'">
    <div class="mt-8 text-center">
        <h1 class="text-2xl font-bold tracking-tight">Masuk ke akun Anda</h1>
        <p class="mt-2 text-sm text-zinc-500">Lanjutkan pengalaman belanja Anda.</p>
    </div>

    @if (session('success'))
        <div class="mt-6 rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="mt-6 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-700">{{ $errors->first() }}</div>
    @endif

    <form class="mt-8 space-y-5" method="POST" action="{{ route('login.store') }}">
        @csrf
        <div>
            <label class="mb-2 block text-sm font-semibold" for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="nama@email.com" class="auth-input">
        </div>
        <div>
            <div class="mb-2 flex items-center justify-between gap-4"><label class="block text-sm font-semibold" for="password">Password</label><a class="text-xs text-zinc-500 hover:text-black" href="#">Lupa password?</a></div>
            <input id="password" name="password" type="password" required autocomplete="current-password" placeholder="Masukkan password" class="auth-input">
        </div>
        <label class="flex items-center gap-2 text-sm text-zinc-600"><input name="remember" type="checkbox" value="1" class="size-4 rounded border-zinc-300 accent-black"> Ingat saya</label>
        <button class="auth-button" type="submit">Masuk <span aria-hidden="true">&#8594;</span></button>
    </form>

    <div class="my-7 flex items-center gap-3 text-xs text-zinc-400"><span class="h-px flex-1 bg-zinc-200"></span><span>ATAU</span><span class="h-px flex-1 bg-zinc-200"></span></div>
    <p class="text-center text-sm text-zinc-600">Belum punya akun? <a class="font-bold text-zinc-950 underline underline-offset-4" href="{{ route('register') }}">Daftar sekarang</a></p>
</x-layouts.auth>
