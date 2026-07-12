<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Rombel;
use App\Models\TahunAjaran;
use App\Http\Requests\KelasRombelRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

// Controller for creating grades & study groups together.
class KelasRombelController extends Controller
{
    // Show the combined grade + study group creation form.
    public function createKelasRombel()
    {
        $jurusans = Jurusan::orderBy('singkatan')->get();
        $tahunAjaran = TahunAjaran::where('aktif', true)->first();

        return view('kelas.form-kelas-rombel', compact('jurusans', 'tahunAjaran'));
    }

    // Store a new grade and its associated study groups.
    public function storeKelasRombel(KelasRombelRequest $req): RedirectResponse
    {
        $kelas = Kelas::create($req->only('jurusan_id', 'tingkat'));

        if ($req->filled('rombels')) {
            foreach ($req->rombels as $rombel) {
                Rombel::create([
                    'kelas_id' => $kelas->id,
                    'tahun_ajaran_id' => $rombel['tahun_ajaran_id'],
                    'tingkat' => $rombel['tingkat'],
                ]);
            }
        }

        return redirect()->route('kelas')->with('success', 'Kelas & rombel berhasil ditambahkan.');
    }

    // Delete a study group.
    public function destroyKelasRombel(Rombel $rombel): RedirectResponse
    {
        $rombel->delete();

        return redirect()->route('kelas')->with('success', 'Rombel berhasil dihapus.');
    }
}
