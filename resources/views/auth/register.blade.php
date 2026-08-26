<x-layouts.auth :title="'Daftar | SHOP.CO'">
    <div class="mt-8 text-center">
        <h1 class="text-2xl font-bold tracking-tight">Buat akun baru</h1>
        <p class="mt-2 text-sm text-zinc-500">Bergabunglah dan mulai berbelanja.</p>
    </div>

    @if ($errors->any())
        <div class="mt-6 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-700">{{ $errors->first() }}</div>
    @endif

    <form class="mt-8 space-y-4" method="POST" action="{{ route('register.store') }}">
        @csrf
        <div><label class="mb-2 block text-sm font-semibold" for="name">Nama lengkap</label><input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap Anda" class="auth-input"></div>
        <div><label class="mb-2 block text-sm font-semibold" for="email">Email</label><input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@email.com" class="auth-input"></div>
        <fieldset><legend class="mb-2 block text-sm font-semibold">Daftar sebagai</legend><div class="grid grid-cols-2 gap-3"><label class="flex cursor-pointer items-center gap-2 rounded-xl border border-zinc-200 px-4 py-3 text-sm transition has-[:checked]:border-black has-[:checked]:bg-zinc-50"><input name="role" type="radio" value="pembeli" @checked(old('role', 'pembeli') === 'pembeli') class="accent-black"> Pembeli</label><label class="flex cursor-pointer items-center gap-2 rounded-xl border border-zinc-200 px-4 py-3 text-sm transition has-[:checked]:border-black has-[:checked]:bg-zinc-50"><input name="role" type="radio" value="penjual" @checked(old('role') === 'penjual') class="accent-black"> Penjual</label></div></fieldset>
        <div><label class="mb-2 block text-sm font-semibold" for="password">Password</label><input id="password" name="password" type="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" class="auth-input"></div>
        <div><label class="mb-2 block text-sm font-semibold" for="password_confirmation">Konfirmasi password</label><input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="Ulangi password" class="auth-input"></div>
        <button class="auth-button mt-2" type="submit">Daftar sekarang <span aria-hidden="true">&#8594;</span></button>
    </form>
    <p class="mt-7 text-center text-sm text-zinc-600">Sudah punya akun? <a class="font-bold text-zinc-950 underline underline-offset-4" href="{{ route('login') }}">Masuk</a></p>
</x-layouts.auth>
