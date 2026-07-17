<?php

namespace App\Http\Controllers;

use App\Models\Kurikulum;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class KurikulumController extends Controller
{
    public function index()
    {
        $kurikulums = Kurikulum::orderBy('nama', 'asc')->get();
        return view('kurikulum.index', compact('kurikulums'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'nullable|string|max:50',
            'status' => 'boolean'
        ]);

        Kurikulum::create([
            'nama' => $request->nama,
            'kode' => $request->kode,
            'status' => $request->has('status') ? true : false,
        ]);

        return redirect()->route('kurikulum.index')->with('success', 'Kurikulum berhasil ditambahkan.');
    }

    public function update(Request $request, Kurikulum $kurikulum): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'nullable|string|max:50',
            'status' => 'boolean'
        ]);

        $kurikulum->update([
            'nama' => $request->nama,
            'kode' => $request->kode,
            'status' => $request->has('status') ? true : false,
        ]);

        return redirect()->route('kurikulum.index')->with('success', 'Data kurikulum berhasil diperbarui.');
    }

    public function destroy(Kurikulum $kurikulum): RedirectResponse
    {
        if ($kurikulum->rombels()->count() > 0) {
            return redirect()->route('kurikulum.index')->with('error', 'Gagal menghapus! Kurikulum ini masih digunakan oleh rombel.');
        }

        $kurikulum->delete();
        return redirect()->route('kurikulum.index')->with('success', 'Kurikulum berhasil dihapus.');
    }
}
