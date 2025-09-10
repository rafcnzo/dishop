<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PenjualController extends Controller
{
    public function DashboardPenjual() {
        return view('penjual.index');
    }

    public function ProfilPenjual() {
        $id = Auth::user()->id;
        $pData = User::find($id);

        return view('penjual.profil', compact('pData'));
    }

    public function ProfilPenjualStore(Request $request) {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->nama     = $request->nama;
        $data->email    = $request->email;
        $data->phone    = $request->phone;
        $data->alamat   = $request->alamat;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/images_penjual/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/images_penjual'), $filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notif = array(
            'message' => 'Profil Berhasil Diupdated!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notif);
    }

    public function GantiSandiPenjual() {
        return view('penjual.ganti_sandi');
    }

    public function PenjualUpdateSandi(Request $request) {
        // validasi form
        $request->validate([
            'sandi_lama' => 'required',
            'sandi_baru' => 'required|confirmed'
        ]);

        // cek password lama
        if (!Hash::check($request->sandi_lama, auth::user()->password)) {
            return back()->with('error', 'Sandi lama tidak sesuai!');
        }

        // update sandi baru
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->sandi_baru)
        ]);

        return back()->with('status', 'Sandi Berhasil Diupdate!');
    }

    public function LoginPenjual() {
        return view('penjual.login_penjual');
    }

    public function LogoutPenjual(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/penjual/login');
    }

    public function DashboardPembeli() {
        return view('dashboard');
    }
}
