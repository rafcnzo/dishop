<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama'          => ['required', 'string', 'max:255'],
            'username'      => ['nullable', 'string', 'max:255'],
            'email'         => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'phone'         => ['nullable', 'string', 'max:20'],
            'alamat'        => ['nullable', 'string', 'max:255'],
            'password'      => ['required', 'confirmed', Rules\Password::defaults()],
            'role'          => ['required', 'in:pembeli,penjual'],
        ]);

        // Cek apakah username sudah terpakai (hanya jika diisi)
        if ($request->filled('username')) {
            $usernameExist = User::where('username', $request->username)->exists();
            if ($usernameExist) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['username' => 'Username telah terpakai. Silakan gunakan username lain.']);
            }
        }

        $user = User::create([
            'nama'          => $request->nama,
            'username'      => $request->username,
            'email'         => $request->email,
            'jenis_kelamin' => $request->jenis_kelamin,
            'phone'         => $request->phone,
            'alamat'        => $request->alamat,
            'password'      => Hash::make($request->password),
            'role'          => $request->role,
        ]);

        event(new Registered($user));

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
