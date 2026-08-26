<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt([...$credentials, 'status' => 'aktif'], $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Email atau password yang Anda masukkan salah.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        $destination = $request->user()->role === 'penjual' ? route('seller.products') : route('home');

        return redirect()->intended($destination)->with('success', 'Selamat datang kembali.');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'in:pembeli,penjual'],
            'password' => ['required', 'confirmed', 'string', 'min:8'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'status' => 'aktif',
            'password' => $validated['password'],
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        $destination = $user->role === 'penjual' ? 'seller.products' : 'home';

        return redirect()->route($destination)->with('success', 'Akun berhasil dibuat. Selamat berbelanja!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
