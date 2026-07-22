<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokenController extends Controller
{
    /**
     * Tampilkan daftar token dan form pembuatan token baru.
     */
    public function index()
    {
        // Ambil token milik user yang sedang login
        $tokens = Auth::user()->tokens;
        return view('tokens.index', compact('tokens'));
    }

    /**
     * Simpan/generate token baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'token_name' => 'required|string|max:255',
        ]);

        // Buat token baru
        $token = $request->user()->createToken($request->token_name);

        // Redirect back dan bawa plainTextToken menggunakan flash session
        return back()->with('new_token', $token->plainTextToken);
    }

    /**
     * Hapus / Revoke token berdasarkan ID.
     */
    public function destroy($id)
    {
        // Hapus token milik user login berdasarkan ID
        Auth::user()->tokens()->where('id', $id)->delete();
        
        return back()->with('success', 'Token berhasil di-revoke/dihapus.');
    }
}
